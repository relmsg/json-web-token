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

namespace RM\Security\Jwt\Util;

/**
 * Class Base64Url implements Base64 standard for URLs (RFC 3548, section 4)
 *
 * @package RM\Security\Jwt\Util
 * @author  h1karo <h1karo@outlook.com>
 */
class Base64Url
{
    /**
     * Encode a buffer as base64url.
     *
     * @param string $input data to encode
     *
     * @return string base64url-encoded data
     */
    public static function encode(string $input): string
    {
        return str_replace(['=', '+', '/'], ['', '-', '_'], base64_encode($input));
    }

    /**
     * Convert a base64url encoded string to a Buffer.
     *
     * @param string $input base64url-encoded string
     *
     * @return string decoded data
     */
    public static function decode(string $input): string
    {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $input));
    }
}