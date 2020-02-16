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

use Throwable;

/**
 * Class AlgorithmNotFoundException
 *
 * @package RM\Security\Jwt\Exception
 * @author  h1karo <h1karo@outlook.com>
 */
class AlgorithmNotFoundException extends InvalidTokenException
{
    public function __construct(string $algorithm, Throwable $previous = null)
    {
        parent::__construct(sprintf("The algorithm with name `%s` is not exists.", $algorithm), $previous);
    }
}