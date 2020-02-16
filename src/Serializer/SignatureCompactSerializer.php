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

namespace RM\Security\Jwt\Serializer;

use InvalidArgumentException;
use ParagonIE\ConstantTime\Base64UrlSafe;
use RM\Security\Jwt\Exception\InvalidTokenException;
use RM\Security\Jwt\Token\SignatureToken;
use RM\Security\Jwt\Token\TokenInterface;
use Webmozart\Json\DecodingFailedException;
use Webmozart\Json\EncodingFailedException;
use Webmozart\Json\JsonDecoder;
use Webmozart\Json\JsonEncoder;
use Webmozart\Json\ValidationFailedException;

/**
 * Class CompactSerializer provides JWS Compact Serialization.
 * Compact serialization is a serialization in URL-safe format.
 *
 * @package RM\Security\Jwt\Serializer
 * @author  h1karo <h1karo@outlook.com>
 */
class SignatureCompactSerializer implements SignatureSerializerInterface
{
    /**
     * Delimiter between header, payload and signature parts for compact serialized token.
     *
     * @see SignatureCompactSerializer::serialize()
     * @see SignatureCompactSerializer::deserialize()
     */
    public const TOKEN_DELIMITER = ".";

    /**
     * The token class whose serialization is supported by this serializer.
     *
     * @var string
     */
    private string $class;
    private JsonEncoder $encoder;
    private JsonDecoder $decoder;

    /**
     * @inheritDoc
     */
    public function __construct(string $class = SignatureToken::class)
    {
        $this->class = $class;
        $this->encoder = new JsonEncoder();
        $this->decoder = new JsonDecoder();
        $this->decoder->setObjectDecoding(JsonDecoder::ASSOC_ARRAY);
    }

    /**
     * @inheritDoc
     * @throws InvalidTokenException
     */
    public function serialize(TokenInterface $token, bool $withoutSignature = false): string
    {
        if (!$token instanceof SignatureToken) {
            throw new InvalidArgumentException(
                sprintf(
                    "%s can serialize only %s, given %s",
                    self::class,
                    SignatureToken::class,
                    get_class($token)
                )
            );
        }

        try {
            $jsonHeader = $this->encoder->encode($token->getHeader()->toArray());
            $jsonPayload = $this->encoder->encode($token->getPayload()->toArray());

            $b64Header = Base64UrlSafe::encodeUnpadded($jsonHeader);
            $b64Payload = Base64UrlSafe::encodeUnpadded($jsonPayload);

            if (!$withoutSignature && !empty($token->getSignature())) {
                $b64Signature = Base64UrlSafe::encodeUnpadded($token->getSignature());
                $parts = [$b64Header, $b64Payload, $b64Signature];
            } else {
                $parts = [$b64Header, $b64Payload];
            }

            return implode(self::TOKEN_DELIMITER, $parts);
        } catch (ValidationFailedException|EncodingFailedException $e) {
            throw new InvalidTokenException("The token data is invalid and cannot be serialized in JSON.", $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function deserialize(string $serialized): TokenInterface
    {
        $parts = explode(SignatureCompactSerializer::TOKEN_DELIMITER, $serialized);
        if (sizeof($parts) < 2 || sizeof($parts) > 3) {
            throw new InvalidTokenException("Token must implement JSON Web Token standard or any related standard.");
        }

        try {
            $b64Header = $parts[0];
            $jsonHeader = Base64UrlSafe::decode($b64Header);
            $header = $this->decoder->decode($jsonHeader);

            $b64Payload = $parts[1];
            $jsonPayload = Base64UrlSafe::decode($b64Payload);
            $payload = $this->decoder->decode($jsonPayload);

            if (sizeof($parts) === 3) {
                $b64Signature = $parts[2];
                $signature = Base64UrlSafe::decode($b64Signature);
            }

            return new $this->class($header, $payload, $signature ?? null);
        } catch (ValidationFailedException|DecodingFailedException $e) {
            throw new InvalidTokenException("The token is invalid and cannot be parsed from JSON.", $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function supports($token): bool
    {
        return is_a($token, $this->class, !is_object($token));
    }
}