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

use Throwable;

/**
 * Class IncorrectClaimTypeException
 *
 * @package RM\Security\Jwt\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class IncorrectClaimTypeException extends InvalidClaimException
{
    /**
     * IncorrectClaimTypeException constructor.
     *
     * @param string         $expected
     * @param string         $got
     * @param string         $claim
     * @param Throwable|null $previous
     */
    public function __construct(string $expected, string $got, string $claim, Throwable $previous = null)
    {
        parent::__construct(sprintf("Claim `%s` must be a %s, got %s.", $claim, $expected, $got), $claim, $previous);
    }
}