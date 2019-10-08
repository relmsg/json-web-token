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

namespace RM\Security\Jwt\Event;

/**
 * Class TokenSignedEvent
 *
 * @package RM\Security\Jwt\Event
 * @author  h1karo <h1karo@outlook.com>
 */
class TokenSignEvent extends AbstractSignatureEvent
{
    public const NAME = 'jwt.token.sign';
}