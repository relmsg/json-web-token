<?php
/*
 * This file is a part of Relations Messenger Json Web Token Implementation.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/json-web-token
 * @link      https://dev.relmsg.ru/packages/json-web-token
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/json-web-token
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Jwt\Exception;

use Throwable;

/**
 * Class IncorrectClaimTypeException
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 */
class IncorrectClaimTypeException extends InvalidClaimException
{
    public function __construct(string $expected, string $got, string $claim, Throwable $previous = null)
    {
        parent::__construct(sprintf('Claim `%s` must be a %s, got %s.', $claim, $expected, $got), $claim, $previous);
    }
}
