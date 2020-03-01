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
use RM\Security\Jwt\Factory\DependencyFactory;
use RM\Security\Jwt\Identifier\IdentifierGeneratorInterface;
use RM\Security\Jwt\Identifier\UniqIdGenerator;
use RM\Security\Jwt\Storage\RuntimeTokenStorage;
use RM\Security\Jwt\Storage\TokenStorageInterface;
use RM\Security\Jwt\Token\Payload;

/**
 * Class IdentifierClaimHandler provides processing for { @see Payload::CLAIM_IDENTIFIER } claim.
 *
 * @package RM\Security\Jwt\Handler
 * @author  h1karo <h1karo@outlook.com>
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

    public function __construct(array $properties = [])
    {
        // we will configure these properties ourselves
        parent::__construct(array_diff_key($properties, array_flip(['tokenStorage', 'identifierGenerator'])));

        if (array_key_exists('tokenStorage', $properties)) {
            $property = $properties['tokenStorage'];
            $tokenStorage = DependencyFactory::create()
                ->setMustImplement(TokenStorageInterface::class)
                ->setDependency($property)
                ->build();

            if ($tokenStorage instanceof TokenStorageInterface) {
                $this->tokenStorage = $tokenStorage;
            }
        } else {
            $this->tokenStorage = new RuntimeTokenStorage();
        }

        if (array_key_exists('identifierGenerator', $properties)) {
            $property = $properties['identifierGenerator'];
            $identifierGenerator = DependencyFactory::create()
                ->setMustImplement(IdentifierGeneratorInterface::class)
                ->setDependency($property)
                ->build();

            if ($identifierGenerator instanceof IdentifierGeneratorInterface) {
                $this->identifierGenerator = $identifierGenerator;
            }

        } else {
            $this->identifierGenerator = new UniqIdGenerator();
        }
    }

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
            throw new InvalidArgumentException(
                sprintf(
                    'To use %s required set up the identifier generator.',
                    static::class
                )
            );
        }

        $identifier = $this->identifierGenerator->generate();

        if ($this->tokenStorage === null) {
            throw new InvalidArgumentException(sprintf('To use %s required set up the token storage.', static::class));
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
            throw new InvalidArgumentException(sprintf('To use %s required set up the token storage.', static::class));
        }

        if (!is_string($value)) {
            throw new IncorrectClaimTypeException('string', gettype($value), $this->getClaim());
        }

        return $this->tokenStorage->has($value);
    }
}