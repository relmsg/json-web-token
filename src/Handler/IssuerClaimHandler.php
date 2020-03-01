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

use RM\Security\Jwt\Exception\IssuerViolationException;
use RM\Security\Jwt\Token\Payload;

/**
 * Class IssuedAtClaimHandler
 *
 * @package RM\Security\Jwt\Handler
 * @author  h1karo <h1karo@outlook.com>
 */
class IssuerClaimHandler extends AbstractClaimHandler
{
    /**
     * The identifier of server which issued the token
     *
     * @var string
     */
    public string $issuer;

    /**
     * @inheritDoc
     */
    public function getClaim(): string
    {
        return Payload::CLAIM_ISSUER;
    }

    /**
     * @inheritDoc
     */
    protected function generateValue(): string
    {
        return $this->issuer;
    }

    /**
     * @inheritDoc
     */
    protected function validateValue($value): bool
    {
        if ($this->issuer !== $value) {
            throw new IssuerViolationException($this);
        }

        return true;
    }
}