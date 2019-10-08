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

namespace RM\Security\Jwt\Algorithm\Signature;

use RM\Security\Jwt\Algorithm\AlgorithmInterface;
use RM\Security\Jwt\Key\KeyInterface;

/**
 * Interface SignatureAlgorithmInterface implements Json Web Token standard for signatures (RFC 7618, section 3)
 *
 * @package RM\Security\Jwt\Algorithm\Signature
 * @author  h1karo <h1karo@outlook.com>
 * @see     https://tools.ietf.org/html/rfc7518
 */
interface SignatureAlgorithmInterface extends AlgorithmInterface
{
    /**
     * Sign input with key
     *
     * @param KeyInterface $key
     * @param string       $input
     *
     * @return string
     */
    public function hash(KeyInterface $key, string $input): string;

    /**
     * Verify signature for this input and key pair
     *
     * @param KeyInterface $key
     * @param string       $input
     * @param string       $hash
     *
     * @return bool
     */
    public function verify(KeyInterface $key, string $input, string $hash): bool;
}