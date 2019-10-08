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

namespace RM\Security\Jwt\Key;

use JsonSerializable;

/**
 * Interface KeyInterface implements JSON Web Key standard (RFC 7517)
 *
 * @package RM\Security\Jwt\Key
 * @author  h1karo <h1karo@outlook.com>
 * @see     https://tools.ietf.org/pdf/rfc7517
 */
interface KeyInterface extends JsonSerializable
{
    public const PARAM_KEY_TYPE  = 'kty';
    public const PARAM_KEY_VALUE = 'k';

    public const KEY_TYPE_OCTET = 'oct';
    public const KEY_TYPE_RSA   = 'RSA';

    /**
     * Returns value of parameter if he exists.
     *
     * @param string $parameter
     *
     * @return string
     */
    public function get(string $parameter): string;

    /**
     * Checks if a parameter exists in a key.
     *
     * @param string $parameter
     *
     * @return bool
     */
    public function has(string $parameter): bool;

    /**
     * Returns all parameters for this key or array key format
     *
     * @return array
     */
    public function all(): array;
}