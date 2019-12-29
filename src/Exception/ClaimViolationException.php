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