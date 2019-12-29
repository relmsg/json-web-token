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
class HS256 extends HMAC
{
    /**
     * {@inheritDoc}
     */
    public function name(): string
    {
        return "HS256";
    }

    /**
     * {@inheritDoc}
     */
    protected function getHashAlgorithm(): string
    {
        return "sha256";
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