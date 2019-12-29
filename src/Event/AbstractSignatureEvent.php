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
    private SignatureToken $token;

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