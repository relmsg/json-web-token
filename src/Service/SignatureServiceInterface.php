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

namespace RM\Security\Jwt\Service;

use RM\Security\Jwt\Algorithm\Signature\SignatureAlgorithmInterface;
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
interface SignatureServiceInterface
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

    /**
     * Returns algorithm by name from algorithm manager.
     *
     * @param string $name
     *
     * @return SignatureAlgorithmInterface
     */
    public function findAlgorithm(string $name): SignatureAlgorithmInterface;
}