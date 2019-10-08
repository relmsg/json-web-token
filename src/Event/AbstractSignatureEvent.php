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

use RM\Security\Jwt\Token\SignatureToken;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class AbstractSignatureEvent
 *
 * @package RM\Security\Jwt\Event
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class AbstractSignatureEvent extends Event
{
    /**
     * @var SignatureToken
     */
    private $token;

    /**
     * AbstractSignatureEvent constructor.
     *
     * @param SignatureToken $token
     */
    public function __construct(SignatureToken $token)
    {
        $this->token = $token;
    }

    /**
     * @return SignatureToken
     */
    public function getToken(): SignatureToken
    {
        return $this->token;
    }
}