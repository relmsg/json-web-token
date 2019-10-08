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

use RM\Security\Jwt\Token\TokenInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class TokenCreatedEvent
 *
 * @package RM\Security\Jwt\Event
 * @author  h1karo <h1karo@outlook.com>
 */
class TokenCreatedEvent extends Event
{
    public const NAME = 'jwt.token.created';

    /**
     * @var TokenInterface
     */
    private $token;

    /**
     * TokenCreatedEvent constructor.
     *
     * @param TokenInterface $token
     */
    public function __construct(TokenInterface $token)
    {
        $this->token = $token;
    }

    /**
     * @return TokenInterface
     */
    public function getToken(): TokenInterface
    {
        return $this->token;
    }
}