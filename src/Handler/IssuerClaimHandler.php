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

namespace RM\Security\Jwt\Handler;

use RM\Security\Jwt\Exception\IssuerViolationException;
use RM\Security\Jwt\Token\Payload;

/**
 * Class IssuedAtClaimHandler
 *
 * @package RM\Security\Jwt\Handler
 * @author  h1karo <h1karo@outlook.com>
 * @Annotation
 */
class IssuerClaimHandler extends AbstractClaimHandler
{
    /**
     * @var string name of server who issues token
     */
    public $issuer;

    /**
     * {@inheritDoc}
     */
    public function getClaim(): string
    {
        return Payload::CLAIM_ISSUER;
    }

    /**
     * {@inheritDoc}
     */
    protected function generateValue(): string
    {
        return $this->issuer;
    }

    /**
     * {@inheritDoc}
     */
    protected function validateValue($value): bool
    {
        if ($this->issuer !== $value) {
            throw new IssuerViolationException($this);
        }

        return true;
    }
}