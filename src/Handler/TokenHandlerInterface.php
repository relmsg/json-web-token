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

namespace RM\Security\Jwt\Handler;

use RM\Security\Jwt\Exception\InvalidTokenException;
use RM\Security\Jwt\Token\TokenInterface;

/**
 * Interface ClaimHandlerInterface
 *
 * @package RM\Security\Jwt\Handler
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