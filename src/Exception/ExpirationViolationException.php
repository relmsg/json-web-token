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

namespace RM\Standard\Jwt\Exception;

use RM\Standard\Jwt\Handler\ExpirationClaimHandler;
use Throwable;

/**
 * Class ExpirationViolationException
 *
 * @package RM\Standard\Jwt\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class ExpirationViolationException extends ClaimViolationException
{
    public function __construct(ExpirationClaimHandler $claimHandler, Throwable $previous = null)
    {
        parent::__construct('The token expired.', $claimHandler, $previous);
    }
}