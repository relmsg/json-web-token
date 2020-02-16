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

namespace RM\Security\Jwt\Token;

use InvalidArgumentException;
use RM\Security\Jwt\Algorithm\AlgorithmInterface;
use RM\Security\Jwt\Algorithm\Signature\SignatureAlgorithmInterface;
use RM\Security\Jwt\Serializer\SerializerInterface;
use RM\Security\Jwt\Serializer\SignatureCompactSerializer;
use RM\Security\Jwt\Serializer\SignatureSerializerInterface;
use RM\Security\Jwt\Service\SignatureServiceInterface;

/**
 * Class SignatureToken implements JSON Web Signature standard (RFC 7515)
 *
 * @see     https://tools.ietf.org/pdf/rfc7515
 * @package RM\Security\Jwt\Token
 * @author  h1karo <h1karo@outlook.com>
 */
class SignatureToken implements TokenInterface
{
    private Header $header;
    private Payload $payload;

    /**
     * Token signature.
     * Empty signature is a valid signature with {@see NoneAlgorithm}.
     *
     * @var string|null
     * @see SignatureServiceInterface::sign()
     */
    private ?string $signature;

    final public function __construct(array $header = [], array $payload = [], string $signature = null)
    {
        $this->header = new Header($header);
        $this->payload = new Payload($payload);
        $this->signature = $signature;
    }

    /**
     * @inheritDoc
     */
    public function getHeader(): Header
    {
        return $this->header;
    }

    /**
     * @inheritDoc
     */
    public function getAlgorithm(): string
    {
        return $this->header->get(Header::CLAIM_ALGORITHM);
    }

    /**
     * Returns new instance of the token with updated algorithm.
     *
     * @param SignatureAlgorithmInterface $algorithm
     *
     * @return TokenInterface
     */
    public function setAlgorithm(SignatureAlgorithmInterface $algorithm): TokenInterface
    {
        $token = clone $this;
        $token->header->set(Header::CLAIM_ALGORITHM, $algorithm->name());
        return $token;
    }

    /**
     * @inheritDoc
     */
    public function getPayload(): Payload
    {
        return $this->payload;
    }

    /**
     * Returns current token signature.
     *
     * @return string|null
     */
    public function getSignature(): ?string
    {
        return $this->signature;
    }

    /**
     * Returns new instance of the token with signature.
     *
     * @param string|null $signature
     *
     * @return SignatureToken
     */
    public function setSignature(?string $signature): SignatureToken
    {
        $token = clone $this;
        $token->signature = $signature;
        return $token;
    }

    /**
     * Defines that signature successful signed or not.
     *
     * @return bool
     */
    public function isSigned(): bool
    {
        return $this->signature !== null;
    }

    /**
     * @inheritDoc
     */
    public function toString(SerializerInterface $serializer, bool $withoutSignature = false): string
    {
        if (!$serializer instanceof SignatureSerializerInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    "%s can be serialized only with %s.",
                    self::class,
                    SignatureSerializerInterface::class
                )
            );
        }

        return $serializer->serialize($this, $withoutSignature);
    }

    /**
     * On cloning the signature should be removed.
     */
    public function __clone()
    {
        $this->signature = null;
    }

    /**
     * Returns compact serialized token.
     *
     * @return string
     * @see SignatureCompactSerializer::serialize()
     */
    public function __toString()
    {
        $serializer = new SignatureCompactSerializer(self::class);
        return $this->toString($serializer);
    }

    /**
     * @inheritDoc
     */
    final public static function createWithAlgorithm(AlgorithmInterface $algorithm): self
    {
        return new static([Header::CLAIM_ALGORITHM => $algorithm->name()]);
    }
}