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

namespace RM\Security\Jwt\Handler;

/**
 * Trait LeewayHandlerTrait
 *
 * @package RM\Security\Jwt\Handler
 */
trait LeewayHandlerTrait
{
    /**
     * Allowed leeway in seconds. By default is 0.
     * For security reason, cannot be more than 2 minutes.
     *
     * @var int
     */
    public $leeway = 0;

    /**
     * Max leeway value.
     * By default is 2 minutes.
     *
     * @var int
     */
    private $maxLeeway = 2 * 60;

    /**
     * @return int
     */
    protected function getLeeway(): int
    {
        return $this->leeway <= $this->maxLeeway ? $this->leeway : $this->maxLeeway;
    }
}