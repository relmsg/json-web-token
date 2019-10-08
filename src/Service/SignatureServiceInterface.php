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

namespace RM\Security\Jwt\Service;

use RM\Security\Jwt\Event\TokenPreSignEvent;
use RM\Security\Jwt\Event\TokenSignEvent;
use RM\Security\Jwt\Exception\ClaimViolationException;
use RM\Security\Jwt\Exception\InvalidTokenException;
use RM\Security\Jwt\Key\KeyInterface;
use RM\Security\Jwt\Token\SignatureToken;

/**
 * Interface SignatureServiceInterface
 *
 * @package RM\Security\Jwt\Service
 * @author  h1karo <h1karo@outlook.com>
 */
interface SignatureServiceInterface extends TokenServiceInterface
{
    /**
     * Sign token with this key.
     * This method triggers some events that call handlers for some claims.
     *
     * @param SignatureToken $token
     * @param KeyInterface   $key
     *
     * @return SignatureToken
     * @throws InvalidTokenException
     * @see TokenPreSignEvent
     * @see TokenSignEvent
     */
    public function sign(SignatureToken $token, KeyInterface $key): SignatureToken;

    /**
     * Verify that token is valid and signature is exist and correct.
     *
     * @param SignatureToken $token
     * @param KeyInterface   $key
     *
     * @return bool
     * @throws ClaimViolationException
     * @throws InvalidTokenException
     */
    public function verify(SignatureToken $token, KeyInterface $key): bool;
}