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

use InvalidArgumentException;
use RM\Security\Jwt\Exception\IncorrectClaimTypeException;
use RM\Security\Jwt\Storage\IdentifierGeneratorInterface;
use RM\Security\Jwt\Storage\TokenStorageInterface;
use RM\Security\Jwt\Token\Payload;

/**
 * Class IdentifierClaimHandler
 *
 * @package RM\Security\Jwt\Handler
 * @author  h1karo <h1karo@outlook.com>
 * @Annotation
 */
class IdentifierClaimHandler extends AbstractClaimHandler
{
    public IdentifierGeneratorInterface $identifierGenerator;
    public TokenStorageInterface $tokenStorage;

    /**
     * Duration of token in seconds. By default is 1 hour.
     * For security reason, cannot be infinite.
     *
     * @var int
     */
    public int $duration = 60 * 60;

    /**
     * @inheritDoc
     */
    public function getClaim(): string
    {
        return Payload::CLAIM_IDENTIFIER;
    }

    /**
     * @inheritDoc
     */
    protected function generateValue(): string
    {
        if ($this->identifierGenerator === null) {
            throw new InvalidArgumentException(sprintf("To use %s required set up the identifier generator.", get_called_class()));
        }

        $identifier = $this->identifierGenerator->generate();

        if ($this->tokenStorage === null) {
            throw new InvalidArgumentException(sprintf("To use %s required set up the token storage.", get_called_class()));
        }

        $this->tokenStorage->put($identifier, $this->duration);
        return $identifier;
    }

    /**
     * @inheritDoc
     */
    protected function validateValue($value): bool
    {
        if ($this->tokenStorage === null) {
            throw new InvalidArgumentException(sprintf("To use %s required set up the token storage.", get_called_class()));
        }

        if (!is_string($value)) {
            throw new IncorrectClaimTypeException('string', gettype($value), $this->getClaim());
        }

        return $this->tokenStorage->has($value);
    }
}