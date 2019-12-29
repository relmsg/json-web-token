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

use RM\Security\Jwt\Generator\ExpirationGenerator;
use RM\Security\Jwt\Generator\IssuerGenerator;
use RM\Security\Jwt\Storage\TokenStorageInterface;
use RM\Security\Jwt\Validator\Constraints\ExpirationConstraint;
use RM\Security\Jwt\Validator\Constraints\IssuerConstraint;

/**
 * Class Payload
 *
 * @package RM\Security\Jwt\Token
 * @author  h1karo <h1karo@outlook.com>
 */
class Payload extends ClaimCollection
{
    /**
     * Issuer is a unique identity of token generator server, authentication server or security server.
     * You can set this claim to check where token generated.
     * It is maybe helps you if you use several servers with own token id { @see Payload::CLAIM_ID } cache server { @see TokenStorageInterface }.
     * We recommend to set this claim.
     * You can just use { @see IssuerGenerator } and { @see IssuerConstraint } to manage this claim.
     */
    public const CLAIM_ISSUER = 'iss';
    /**
     * Subject is a unique identity of application who wants to get access to the audience { @see Payload::CLAIM_AUDIENCE }.
     * It is required claim.
     */
    public const CLAIM_SUBJECT = 'sub';
    /**
     * Audience is a unique identity of object token provides access to.
     * It is required claim. May have same value as { @see Payload::CLAIM_SUBJECT }.
     */
    public const CLAIM_AUDIENCE = 'aud';
    /**
     * Expiration is a time in UNIX format when token expires.
     * It is required claim.
     * You can just use { @see ExpirationGenerator } and { @see ExpirationConstraint } to manage this claim.
     */
    public const CLAIM_EXPIRATION = 'exp';
    public const CLAIM_NOT_BEFORE = 'nbf';
    public const CLAIM_ISSUED_AT  = 'iat';
    public const CLAIM_ID         = 'jti';
}