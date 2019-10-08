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

namespace RM\Security\Jwt\Token;

/**
 * Interface TokenInterface
 *
 * @package RM\Security\Jwt\Token
 * @author  h1karo <h1karo@outlook.com>
 */
interface TokenInterface
{
    /**
     * Delimiter between header, payload and signature parts for compact serialized token
     *
     * @see toString()
     */
    public const TOKEN_DELIMITER = ".";

    /**
     * Returns array collection of header parameters
     *
     * @return Header
     */
    public function getHeader(): Header;

    /**
     * Returns array collection of payload parameters
     *
     * @return Payload
     */
    public function getPayload(): Payload;

    /**
     * Returns compact serialized token string
     *
     * @return string
     */
    public function toString(): string;

    /**
     * Returns token object from compact serialized token string.
     * This method does not validate token.
     *
     * @param string $serialized
     *
     * @return static
     */
    public static function fromString(string $serialized);
}