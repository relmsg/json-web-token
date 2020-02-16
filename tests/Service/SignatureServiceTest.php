<?php
/**
 * Relations Messenger Json Web Token Implementation
 *
 * @link      https://gitlab.com/relmsg/json-web-token
 * @link      https://dev.relmsg.ru/json-web-token
 * @copyright Copyright (c) 2018-2019 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/json-web-token
 */

namespace RM\Security\Jwt\Tests\Service;

use BenTools\CartesianProduct\CartesianProduct;
use Exception;
use Generator;
use Laminas\Math\Rand;
use ParagonIE\ConstantTime\Base64UrlSafe;
use PHPUnit\Framework\TestCase;
use RM\Security\Jwt\Algorithm\AlgorithmInterface;
use RM\Security\Jwt\Algorithm\AlgorithmManager;
use RM\Security\Jwt\Algorithm\Signature\HS256;
use RM\Security\Jwt\Algorithm\Signature\HS512;
use RM\Security\Jwt\Algorithm\Signature\Keccak256;
use RM\Security\Jwt\Exception\AlgorithmNotFoundException;
use RM\Security\Jwt\Exception\InvalidTokenException;
use RM\Security\Jwt\Handler\ExpirationClaimHandler;
use RM\Security\Jwt\Handler\IdentifierClaimHandler;
use RM\Security\Jwt\Handler\IssuedAtClaimHandler;
use RM\Security\Jwt\Handler\IssuerClaimHandler;
use RM\Security\Jwt\Handler\NotBeforeClaimHandler;
use RM\Security\Jwt\Handler\TokenHandlerList;
use RM\Security\Jwt\Identifier\RandomUuidGenerator;
use RM\Security\Jwt\Key\KeyInterface;
use RM\Security\Jwt\Key\OctetKey;
use RM\Security\Jwt\Service\SignatureService;
use RM\Security\Jwt\Storage\RedisTokenStorage;
use RM\Security\Jwt\Token\Payload;
use RM\Security\Jwt\Token\SignatureToken;
use RM\Security\Jwt\Token\TokenInterface;

class SignatureServiceTest extends TestCase
{
    public function testCreation(): SignatureService
    {
        $algorithmManager = new AlgorithmManager($this->getAlgorithms());
        $handlerList = $this->createTokenHandlerList();
        $signatureService = new SignatureService($algorithmManager, $handlerList);

        $this->assertInstanceOf(SignatureService::class, $signatureService);
        $this->assertInstanceOf(AlgorithmManager::class, $signatureService->getAlgorithmManager());
        $this->assertEquals($algorithmManager, $signatureService->getAlgorithmManager());

        return $signatureService;
    }

    public function createTokenHandlerList(): TokenHandlerList
    {
        if (!defined('REDIS_HOST')) {
            throw new Exception('No redis host constant.');
        }

        $issuerClaimHandler = new IssuerClaimHandler();
        $issuerClaimHandler->issuer = 'test';

        $identifierClaimHandler = new IdentifierClaimHandler();
        $identifierClaimHandler->tokenStorage = new RedisTokenStorage(REDIS_HOST);
        $identifierClaimHandler->identifierGenerator = new RandomUuidGenerator();

        return new TokenHandlerList(
            [
                $issuerClaimHandler,
                new ExpirationClaimHandler(),
                new NotBeforeClaimHandler(),
                new IssuedAtClaimHandler(),
                $identifierClaimHandler
            ]
        );
    }

    /**
     * @depends      testCreation
     * @dataProvider provideKeyAndAlgorithm
     *
     * @param AlgorithmInterface $algorithm
     * @param KeyInterface       $key
     * @param SignatureService   $service
     *
     * @return TokenInterface
     * @throws InvalidTokenException
     */
    public function testSign(
        AlgorithmInterface $algorithm,
        KeyInterface $key,
        SignatureService $service
    ): TokenInterface {
        $token = SignatureToken::createWithAlgorithm($algorithm);

        $signedToken = $service->sign($token, $key);
        $this->assertInstanceOf(TokenInterface::class, $signedToken);
        $this->assertTrue($signedToken->isSigned());
        $this->assertFalse($token->isSigned());

        $this->assertTrue($signedToken->getPayload()->containsKey(Payload::CLAIM_ISSUER));
        $this->assertEquals('test', $signedToken->getPayload()->get(Payload::CLAIM_ISSUER));
        $this->assertTrue($signedToken->getPayload()->containsKey(Payload::CLAIM_EXPIRATION));
        $this->assertTrue($signedToken->getPayload()->containsKey(Payload::CLAIM_ISSUED_AT));
        $this->assertTrue($signedToken->getPayload()->containsKey(Payload::CLAIM_NOT_BEFORE));
        $this->assertTrue($signedToken->getPayload()->containsKey(Payload::CLAIM_IDENTIFIER));

        $this->assertFalse($token->getPayload()->containsKey(Payload::CLAIM_ISSUER));
        $this->assertFalse($token->getPayload()->containsKey(Payload::CLAIM_EXPIRATION));
        $this->assertFalse($token->getPayload()->containsKey(Payload::CLAIM_ISSUED_AT));
        $this->assertFalse($token->getPayload()->containsKey(Payload::CLAIM_NOT_BEFORE));
        $this->assertFalse($token->getPayload()->containsKey(Payload::CLAIM_IDENTIFIER));

        $this->assertTrue($service->verify($signedToken, $key));
        $this->assertFalse($service->verify($signedToken->setSignature(null), $key));

        $this->expectException(AlgorithmNotFoundException::class);
        $this->assertFalse($service->verify($signedToken->setAlgorithm(new HS512())->setSignature($signedToken->getSignature()), $key));

        $this->expectException(InvalidTokenException::class);
        $this->assertFalse($service->verify($token, $key));

        return $signedToken;
    }

    public function provideKeyAndAlgorithm(): Generator
    {
        $cartesian = new CartesianProduct([$this->getAlgorithms(), iterator_to_array($this->getKey())]);
        foreach ($cartesian->getIterator() as $arguments) {
            yield $arguments;
        }
    }

    public function getAlgorithms(): array
    {
        return [
            new HS256(),
            new Keccak256()
        ];
    }

    public function getKey(): Generator
    {
        yield new OctetKey(Base64UrlSafe::encode(Rand::getBytes(64)));
    }
}
