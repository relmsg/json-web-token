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

namespace RM\Security\Jwt\Token;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ClaimCollection
 *
 * @package RM\Security\Jwt\Token
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class ClaimCollection extends ArrayCollection
{
    /**
     * ClaimCollection constructor.
     *
     * @param array $parameters
     * @param array $defaults
     */
    public function __construct(array $parameters = [], array $defaults = [])
    {
        parent::__construct(array_merge($defaults, $parameters));
    }
}