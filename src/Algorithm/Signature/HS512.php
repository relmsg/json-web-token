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

use InvalidArgumentException;
use RM\Security\Jwt\Key\KeyInterface;

/**
 * Class HS256
 *
 * @package RM\Security\Jwt\Signature
 * @author  h1karo <h1karo@outlook.com>
 */
class HS512 extends HMAC
{
    /**
     * Returns the name of the algorithm.
     */
    public function name(): string
    {
        return "HS512";
    }

    /**
     * Returns name of HMAC hash algorithm like "sha256"
     *
     * @return string
     */
    protected function getHashAlgorithm(): string
    {
        return "sha512";
    }

    /**
     * @param KeyInterface $key
     *
     * @return string
     */
    protected function getKey(KeyInterface $key): string
    {
        $k = parent::getKey($key);

        if (mb_strlen($k, '8bit') < 32) {
            throw new InvalidArgumentException('Invalid key length.');
        }

        return $k;
    }
}