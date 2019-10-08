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