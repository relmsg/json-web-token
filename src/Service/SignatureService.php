<?php
/**
 * This file is a part of Relations Messenger Json Web Token Implementation.
 * This package is a part of Relations Messenger.
 *
 * @link      https://gitlab.com/relmsg/json-web-token
 * @link      https://dev.relmsg.ru/packages/json-web-token
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/json-web-token
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Security\Jwt\Service;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use InvalidArgumentException;
use ParagonIE\ConstantTime\Base64UrlSafe;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use ReflectionClass;
use ReflectionException;
use RM\Security\Jwt\Algorithm\AlgorithmManager;
use RM\Security\Jwt\Algorithm\Signature\SignatureAlgorithmInterface;
use RM\Security\Jwt\Event\TokenPreSignEvent;
use RM\Security\Jwt\Event\TokenSignEvent;
use RM\Security\Jwt\Exception\InvalidTokenException;
use RM\Security\Jwt\Handler\TokenHandlerInterface;
use RM\Security\Jwt\Handler\TokenHandlerList;
use RM\Security\Jwt\Key\KeyInterface;
use RM\Security\Jwt\Storage\TokenStorageInterface;
use RM\Security\Jwt\Token\SignatureToken;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class SignatureService
 *
 * @package RM\Security\Jwt\Service
 * @author  h1karo <h1karo@outlook.com>
 */
class SignatureService implements SignatureServiceInterface
{
    private AlgorithmManager $algorithmManager;
    private ?TokenStorageInterface $tokenStorage;
    private ?TokenHandlerList $handlerList;
    private EventDispatcherInterface $eventDispatcher;
    private LoggerInterface $logger;

    /**
     * SignatureService constructor.
     *
     * @param AlgorithmManager              $algorithmManager
     * @param TokenStorageInterface|null    $tokenStorage
     * @param TokenHandlerList|null         $handlerList
     * @param EventDispatcherInterface|null $eventDispatcher
     * @param LoggerInterface|null          $logger
     */
    public function __construct(
        AlgorithmManager $algorithmManager,
        TokenStorageInterface $tokenStorage = null,
        TokenHandlerList $handlerList = null,
        EventDispatcherInterface $eventDispatcher = null,
        LoggerInterface $logger = null
    ) {
        $this->algorithmManager = $algorithmManager;
        $this->tokenStorage = $tokenStorage;
        $this->handlerList = $handlerList ?? new TokenHandlerList();
        $this->eventDispatcher = $eventDispatcher ?? new EventDispatcher();
        $this->logger = $logger ?? new NullLogger();
    }

    /**
     * {@inheritDoc}
     */
    final public function sign(SignatureToken $token, KeyInterface $key, bool $resign = false): SignatureToken
    {
        if (!$resign && $token->isSigned()) {
            throw new InvalidTokenException("This token already signed. If you wants to resign them, set `resign` argument on `true`.");
        }

        $this->logger->info(
            "Token sign started.",
            [
                'service' => get_class($this),
                'token' => $token
            ]
        );

        $algorithm = $this->findAlgorithm($token->getAlgorithm());

        $this->logger->debug(
            "Found a algorithm to sign.",
            ['algorithm' => $algorithm->name()]
        );

        $preSignEvent = new TokenPreSignEvent($token);
        $this->eventDispatcher->dispatch($preSignEvent, TokenPreSignEvent::NAME);

        $handlerList = $this->findTokenHandlers($token);
        $handlerList->generate($token);

        $this->logger->debug(
            "Handlers processed the token.",
            ['algorithm' => $algorithm->name()]
        );

        $signature = $algorithm->hash($key, $token->toString(true));
        $signedToken = $token->setSignature($signature);
        $signedToken->setSigned(true);

        $this->logger->debug(
            "Signature generated with hash algorithm.",
            [
                'signature (base64url encoded)' => Base64UrlSafe::encode($signature),
                'algorithm' => $algorithm->name()
            ]
        );

        $signEvent = new TokenSignEvent($signedToken);
        $this->eventDispatcher->dispatch($signEvent, TokenSignEvent::NAME);

        $this->logger->info(
            "Token sign complete successful.",
            ['token' => $signedToken]
        );

        return $signedToken;
    }

    /**
     * {@inheritDoc}
     */
    final public function verify(SignatureToken $token, KeyInterface $key): bool
    {
        $handlerList = $this->findTokenHandlers($token);
        if (!$handlerList->validate($token)) {
            return false;
        }

        $resignedToken = $this->sign($token, $key, true);
        return $token->getSignature() === $resignedToken->getSignature();
    }

    /**
     * Returns signature algorithm by name from manager
     *
     * @param string $name
     *
     * @return SignatureAlgorithmInterface
     */
    public function findAlgorithm(string $name): SignatureAlgorithmInterface
    {
        $algorithm = $this->algorithmManager->get($name);

        if (!$algorithm instanceof SignatureAlgorithmInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'Signature algorithm must implement %1$s, given %2$s.',
                    SignatureAlgorithmInterface::class,
                    get_class($algorithm)
                )
            );
        }

        return $algorithm;
    }

    /**
     * @return AlgorithmManager
     */
    public function getAlgorithmManager(): AlgorithmManager
    {
        return $this->algorithmManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenStorage(): ?TokenStorageInterface
    {
        return $this->tokenStorage;
    }

    /**
     * @param SignatureToken $token
     *
     * @return TokenHandlerList
     */
    protected function findTokenHandlers(SignatureToken $token): TokenHandlerList
    {
        $handlerList = clone $this->handlerList;

        $annotations = $this->findAnnotations($token, TokenHandlerInterface::class);
        if (!empty($annotations)) {
            foreach ($annotations as $annotation) {
                $handlerList->add($annotation);
            }
        }

        return $handlerList;
    }

    /**
     * @param object $object
     * @param string $class
     *
     * @return array|null
     */
    private function findAnnotations(object $object, string $class)
    {
        try {
            $annotations = [];

            $reflect = new ReflectionClass($object);
            $reader = new AnnotationReader();
            foreach ($reader->getClassAnnotations($reflect) as $annotation) {
                if ($annotation instanceof $class) {
                    $annotations[] = $annotation;
                }
            }

            return $annotations;
        } catch (ReflectionException | AnnotationException $e) {
            return null;
        }
    }
}