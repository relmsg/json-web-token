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

use RM\Security\Jwt\Exception\IncorrectClaimTypeException;
use RM\Security\Jwt\Exception\NotBeforeViolationException;
use RM\Security\Jwt\Token\Payload;

/**
 * Class IssuedAtClaimHandler
 *
 * @package RM\Security\Jwt\Handler
 * @author  h1karo <h1karo@outlook.com>
 * @Annotation
 */
class NotBeforeClaimHandler extends AbstractClaimHandler
{
    use LeewayHandlerTrait;

    /**
     * {@inheritDoc}
     */
    public function getClaim(): string
    {
        return Payload::CLAIM_NOT_BEFORE;
    }

    /**
     * {@inheritDoc}
     */
    protected function generateValue(): int
    {
        return time();
    }

    /**
     * {@inheritDoc}
     */
    protected function validateValue($value): bool
    {
        if (!is_int($value)) {
            throw new IncorrectClaimTypeException('integer', gettype($value), $this->getClaim());
        }

        if (time() < $value - $this->getLeeway()) {
            throw new NotBeforeViolationException($this);
        }

        return true;
    }
}