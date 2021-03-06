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

namespace RM\Standard\Jwt\Handler;

/**
 * Trait LeewayHandlerTrait
 *
 */
trait LeewayHandlerTrait
{
    public function __construct(int $leeway = 0)
    {
        $this->leeway = $leeway;
    }

    /**
     * Allowed leeway in seconds. By default is 0.
     * For security reason, cannot be more than 2 minutes.
     *
     * @var int
     */
    protected int $leeway = 0;

    /**
     * Max leeway value.
     * By default is 2 minutes.
     *
     * @var int
     */
    private int $maxLeeway = 2 * 60;

    /**
     * @return int
     */
    final protected function getLeeway(): int
    {
        return $this->leeway <= $this->maxLeeway ? $this->leeway : $this->maxLeeway;
    }
}
