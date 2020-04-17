<?php
/**
 * This file is a part of Relations Messenger Json Web Token Implementation.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/json-web-token
 * @link      https://dev.relmsg.ru/packages/json-web-token
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    h1karo <h1karo@outlook.com>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/json-web-token
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Jwt\Handler;

use RM\Standard\Jwt\Exception\InvalidTokenException;
use RM\Standard\Jwt\Token\TokenInterface;

/**
 * Interface ClaimHandlerInterface
 *
 * @package RM\Standard\Jwt\Handler
 * @author  h1karo <h1karo@outlook.com>
 */
interface TokenHandlerInterface
{
    /**
     * Generate new value for current claim
     *
     * @param TokenInterface $token
     */
    public function generate(TokenInterface $token): void;

    /**
     * Checks if the passed value is valid.
     *
     * @param TokenInterface $token
     *
     * @return bool
     * @throws InvalidTokenException
     */
    public function validate(TokenInterface $token): bool;
}