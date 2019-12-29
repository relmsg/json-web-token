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