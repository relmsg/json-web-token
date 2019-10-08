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

use RM\Security\Jwt\Handler\AbstractClaimHandler;
use Throwable;

/**
 * Class ViolationException
 * This class isn't related to symfony validation package.
 *
 * @package RM\Security\Jwt\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class ClaimViolationException extends InvalidClaimException
{
    /**
     * @var AbstractClaimHandler
     */
    private $claimHandler;

    /**
     * ViolationException constructor.
     *
     * @param string               $message
     * @param AbstractClaimHandler $claimHandler
     * @param Throwable|null       $previous
     */
    public function __construct(string $message, AbstractClaimHandler $claimHandler, Throwable $previous = null)
    {
        parent::__construct($message, $claimHandler->getClaim(), $previous);
        $this->claimHandler = $claimHandler;
    }

    /**
     * @return AbstractClaimHandler
     */
    public function getClaimHandler(): AbstractClaimHandler
    {
        return $this->claimHandler;
    }
}