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

namespace RM\Security\Jwt\Tests\Token;

use RM\Security\Jwt\Handler\ExpirationClaimHandler;
use RM\Security\Jwt\Handler\IssuedAtClaimHandler;
use RM\Security\Jwt\Handler\IssuerClaimHandler;
use RM\Security\Jwt\Handler\NotBeforeClaimHandler;

/**
 * Class SignatureToken
 *
 * @package RM\Security\Jwt\Tests\Token
 * @author  h1karo <h1karo@outlook.com>
 * @IssuerClaimHandler(issuer="test")
 * @ExpirationClaimHandler()
 * @NotBeforeClaimHandler()
 * @IssuedAtClaimHandler()
 */
class SignatureToken extends \RM\Security\Jwt\Token\SignatureToken
{

}