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

use RM\Security\Jwt\Token\TokenInterface;

/**
 * Interface SignatureSerializerInterface
 *
 * @package RM\Security\Jwt\Serializer
 * @author  h1karo <h1karo@outlook.com>
 */
interface SignatureSerializerInterface extends SerializerInterface
{
    /**
     * Serializes the token in a transfer-safe and short format.
     *
     * @param TokenInterface $token
     * @param bool           $withoutSignature
     *
     * @return string
     */
    public function serialize(TokenInterface $token, bool $withoutSignature = false): string;
}