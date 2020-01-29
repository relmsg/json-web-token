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

use Laminas\Math\Rand;
use Monolog\Handler\PHPConsoleHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use ParagonIE\ConstantTime\Base64UrlSafe;
use PHPUnit\Framework\TestCase;
use RM\Security\Jwt\Algorithm\AlgorithmManager;
use RM\Security\Jwt\Algorithm\Signature\HS256;
use RM\Security\Jwt\Algorithm\Signature\HS512;
use RM\Security\Jwt\Algorithm\Signature\Keccak256;
use RM\Security\Jwt\Algorithm\Signature\Keccak512;
use RM\Security\Jwt\Exception\ClaimViolationException;
use RM\Security\Jwt\Exception\InvalidTokenException;
use RM\Security\Jwt\Key\KeyInterface;
use RM\Security\Jwt\Key\OctetKey;
use RM\Security\Jwt\Service\SignatureService;
use RM\Security\Jwt\Tests\Token\SignatureToken;
use RM\Security\Jwt\Token\Header;
use RM\Security\Jwt\Token\Payload;

class SignatureServiceTest extends TestCase
{
    private SignatureService $service;
    private KeyInterface $key;
    private KeyInterface $anotherKey;

    protected function setUp(): void
    {
        $algorithmManager = new AlgorithmManager();

        foreach ($this->getAlgorithms() as $algorithm) {
            $algorithmManager->put($algorithm);
        }

        $this->key = new OctetKey(Base64UrlSafe::encode(Rand::getBytes(64)));
        $this->anotherKey = new OctetKey(Base64UrlSafe::encode(Rand::getBytes(64)));

        $logger = new Logger('signature_service');
        $logFile = $_SERVER['REQUEST_TIME'];
        $logger->pushHandler(new StreamHandler("../log/{$logFile}.log"));
        $logger->pushHandler(new PHPConsoleHandler());

        $this->service = new SignatureService($algorithmManager, null, null, null, $logger);
    }

    /**
     * @throws InvalidTokenException
     */
    public function testSign()
    {
        $token = new SignatureToken(
            [
                Header::CLAIM_ALGORITHM => (new Keccak512())->name()
            ]
        );

        $signedToken = $this->service->sign($token, $this->key);

        $this->assertEquals(true, $signedToken->isSigned());
        $this->assertEquals(false, $token->isSigned());
    }

    public function testFindAlgorithm()
    {
        $keccak512 = new Keccak512();
        $this->assertEquals($keccak512, $this->service->findAlgorithm($keccak512->name()));
    }

    /**
     * @param SignatureToken $token
     * @param bool           $expected
     *
     * @throws InvalidTokenException
     * @dataProvider getVerifyProvider
     */
    public function testVerify(SignatureToken $token, bool $expected)
    {
        $signedToken = $this->service->sign($token, $this->key);

        $this->assertEquals(true, $signedToken->isSigned());
        $this->assertEquals(false, $token->isSigned());

        if (!$expected) {
            $this->expectException(ClaimViolationException::class);
        }

        $actual = $this->service->verify($signedToken, $this->key);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function getAlgorithms(): array
    {
        return [
            new Keccak512(),
            new Keccak256(),
            new HS512(),
            new HS256()
        ];
    }

    public function getVerifyData(): array
    {
        return [
            [
                [

                ],
                true
            ],
            [
                [
                    Payload::CLAIM_EXPIRATION => 0
                ],
                false
            ],
            [
                [
                    Payload::CLAIM_ISSUER => 'not-test'
                ],
                false
            ]
        ];
    }

    /**
     * @return array
     */
    public function getVerifyProvider(): array
    {
        $algorithms = $this->getAlgorithms();
        $data = $this->getVerifyData();

        $result = [];
        foreach ($algorithms as $algorithm) {
            foreach ($data as $item) {
                $payload = $item[0];
                $expected = $item[1];

                $result[] = [
                    new SignatureToken(
                        [
                            Header::CLAIM_ALGORITHM => $algorithm->name()
                        ], $payload
                    ),
                    $expected
                ];
            }
        }

        return $result;
    }
}
