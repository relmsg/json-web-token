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

use ParagonIE\ConstantTime\Base64UrlSafe;
use RM\Security\Jwt\Algorithm\Signature\SignatureAlgorithmInterface;
use RM\Security\Jwt\Exception\InvalidTokenException;
use Webmozart\Json\JsonDecoder;
use Webmozart\Json\JsonEncoder;
use Webmozart\Json\ValidationFailedException;

/**
 * Class SignatureToken implements JSON Web Signature standard (RFC 7515)
 *
 * @see     https://tools.ietf.org/pdf/rfc7515
 * @package RM\Security\Jwt\Token
 * @author  h1karo <h1karo@outlook.com>
 */
class SignatureToken implements TokenInterface
{
    /**
     * @var Header
     */
    private Header $header;

    /**
     * @var Payload
     */
    private Payload $payload;

    /**
     * Empty signature is a valid signature with { @see NoneAlgorithm }
     *
     * @var string|null
     */
    private ?string $signature = null;

    /**
     * @var bool
     */
    private bool $isSigned = false;

    /**
     * SignatureToken constructor.
     *
     * @param array       $header
     * @param array       $payload
     * @param string|null $signature
     */
    public function __construct(array $header = [], array $payload = [], string $signature = null)
    {
        $this->header = new Header($header);
        $this->payload = new Payload($payload);
        $this->signature = $signature;
    }

    /**
     * {@inheritDoc}
     */
    public function getHeader(): Header
    {
        return $this->header;
    }

    /**
     * @return string
     */
    public function getAlgorithm(): string
    {
        return $this->header->get(Header::CLAIM_ALGORITHM);
    }

    /**
     * @param SignatureAlgorithmInterface $algorithm
     */
    public function setAlgorithm(SignatureAlgorithmInterface $algorithm)
    {
        $this->header->set(Header::CLAIM_ALGORITHM, $algorithm->name());
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     * @throws InvalidTokenException
     */
    public function toString(bool $withoutSignature = false): string
    {
        try {
            $encoder = new JsonEncoder();
            $jsonHeader = $encoder->encode($this->getHeader()->toArray());
            $jsonPayload = $encoder->encode($this->getPayload()->toArray());

            $b64Header = Base64UrlSafe::encode($jsonHeader);
            $b64Payload = Base64UrlSafe::encode($jsonPayload);

            if (!$withoutSignature && !empty($this->signature)) {
                $b64Signature = Base64UrlSafe::encode($this->signature);
                $parts = [$b64Header, $b64Payload, $b64Signature];
            } else {
                $parts = [$b64Header, $b64Payload];
            }

            return implode(self::TOKEN_DELIMITER, $parts);
        } catch (ValidationFailedException $e) {
            throw new InvalidTokenException("The token data is invalid and cannot be serialized in JSON.", $e);
        }
    }

    /**
     * {@inheritDoc}
     * @throws InvalidTokenException
     */
    public static function fromString($serialized): SignatureToken
    {
        $parts = explode(self::TOKEN_DELIMITER, $serialized);
        if (sizeof($parts) < 2 || sizeof($parts) > 3) {
            throw new InvalidTokenException("Token must implement JSON Web Token standard or any related standard.");
        }

        try {
            $decoder = new JsonDecoder();
            $decoder->setObjectDecoding(JsonDecoder::ASSOC_ARRAY);

            $b64Header = $parts[0];
            $jsonHeader = Base64UrlSafe::decode($b64Header);
            $header = $decoder->decode($jsonHeader);

            $b64Payload = $parts[1];
            $jsonPayload = Base64UrlSafe::decode($b64Payload);
            $payload = $decoder->decode($jsonPayload);

            if (sizeof($parts) === 3) {
                $b64Signature = $parts[2];
                $signature = Base64UrlSafe::decode($b64Signature);
            }

            return new static($header, $payload, $signature ?? null);
        } catch (ValidationFailedException $e) {
            throw new InvalidTokenException("The token is invalid and cannot be parsed from JSON.", $e);
        }
    }

    /**
     * @return string
     * @throws InvalidTokenException
     */
    public function __toString()
    {
        return $this->toString();
    }
}