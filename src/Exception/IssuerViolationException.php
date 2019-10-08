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

namespace RM\Security\Jwt\Exception;

use RM\Security\Jwt\Handler\IssuerClaimHandler;
use Throwable;

/**
 * Class IssuerViolationException
 *
 * @package RM\Security\Jwt\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class IssuerViolationException extends ClaimViolationException
{
    /**
     * IssuerViolationException constructor.
     *
     * @param IssuerClaimHandler $claimHandler
     * @param Throwable|null     $previous
     */
    public function __construct(IssuerClaimHandler $claimHandler, Throwable $previous = null)
    {
        parent::__construct("Token issuer is different from current issuer.", $claimHandler, $previous);
    }
}