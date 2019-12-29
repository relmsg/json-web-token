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

namespace RM\Security\Jwt\Algorithm\Signature;

/**
 * Class Keccak256
 *
 * @package RM\Security\Jwt\Algorithm\Signature
 * @author  h1karo <h1karo@outlook.com>
 */
class Keccak256 extends HMAC
{
    /**
     * Returns the name of the algorithm.
     *
     * @return string
     */
    public function name(): string
    {
        return "Keccak256";
    }

    /**
     * Returns name of HMAC hash algorithm like "sha256"
     *
     * @return string
     */
    protected function getHashAlgorithm(): string
    {
        return "sha3-256";
    }
}