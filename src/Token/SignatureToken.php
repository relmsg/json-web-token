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

    private bool $isSigned = false;

    public function __construct(array $header = [], array $payload = [], string $signature = null)
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

    public function getAlgorithm(): string
    {
        return $this->header->get(Header::CLAIM_ALGORITHM);
    }

    public function setAlgorithm(SignatureAlgorithmInterface $algorithm)
    {
        $this->header->set(Header::CLAIM_ALGORITHM, $algorithm->name());
    }

    /**
     * @inheritDoc
     */
    public function getPayload(): Payload
    {
        return $this->payload;
    }

    /**
     * @return string|null
     */
    public function getSignature(): ?string
    {
        return $this->signature;
    }

    /**
     * @param string|null $signature
     *
     * @return SignatureToken
     */
    public function setSignature(?string $signature): SignatureToken
    {
        $token = clone $this;
        $token->signature = $signature;
        $token->isSigned = false;
        return $token;
    }

    /**
     * @return bool
     */
    public function isSigned(): bool
    {
        return $this->isSigned;
    }

    /**
     * @param bool $isSigned
     */
    public function setSigned(bool $isSigned): void
    {
        $this->isSigned = $isSigned;
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
     * Returns compact serialized token.
     *
     * @return string
     * @see SignatureCompactSerializer::serialize()
     */
    public function __toString()
    {
        $serializer = new SignatureCompactSerializer();
        return $this->toString($serializer);
    }
}