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
use RM\Security\Jwt\Identifier\IdentifierGeneratorInterface;
use RM\Security\Jwt\Storage\TokenStorageInterface;
use RM\Security\Jwt\Token\Payload;

/**
 * Class IdentifierClaimHandler provides processing for { @see Payload::CLAIM_IDENTIFIER } claim.
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

    public function __construct(array $properties = [])
    {
        if (array_key_exists('tokenStorage', $properties)) {
            $property = $properties['tokenStorage'];
            $tokenStorage = self::createDependency('tokenStorage', $property);

            if (!$tokenStorage instanceof TokenStorageInterface) {
                throw self::createMustImplementException('tokenStorage', TokenStorageInterface::class, get_class($tokenStorage));
            }

            $this->tokenStorage = $tokenStorage;
        }

        if (array_key_exists('identifierGenerator', $properties)) {
            $property = $properties['identifierGenerator'];
            $identifierGenerator = self::createDependency('identifierGenerator', $property);

            if (!$identifierGenerator instanceof IdentifierGeneratorInterface) {
                throw self::createMustImplementException('identifierGenerator', IdentifierGeneratorInterface::class, get_class($identifierGenerator));
            }

            $this->identifierGenerator = $identifierGenerator;
        }

        if (array_key_exists('duration', $properties)) {
            $this->duration = $properties['duration'];
        }
    }

    /**
     * @param string              $name
     * @param array|object|string $property
     *
     * @return object
     */
    protected function createDependency(string $name, $property): object
    {
        if (is_object($property)) {
            return $property;
        }

        if (is_string($property)) {
            return self::createDependencyFromString($name, $property);
        }

        if (is_array($property)) {
            return self::createDependencyFromArray($name, $property);
        }

        throw self::createMustImplementException($name, TokenStorageInterface::class, is_object($property) ? get_class($property) : gettype($property));
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

    /**
     * @param string $name
     * @param string $property
     *
     * @return object
     */
    protected static function createDependencyFromString(string $name, string $property): object
    {
        if (!class_exists($property)) {
            throw new InvalidArgumentException(
                sprintf('Expects FQCN string with class for %s::%s, got %s.', get_called_class(), $name, $property)
            );
        }

        return new $property();
    }

    /**
     * @param string $name
     * @param array  $property
     *
     * @return object
     */
    protected static function createDependencyFromArray(string $name, array $property): object
    {
        if (count($property) !== 1) {
            throw new InvalidArgumentException(
                sprintf('Array should have only one value to create dependency for %s::%s.', get_called_class(), $name)
            );
        }

        $class = key($property);
        $arguments = $property[$class];
        return new $class(...$arguments);
    }

    /**
     * @param string $property
     * @param string $implement
     * @param string $got
     *
     * @return InvalidArgumentException
     */
    protected static function createMustImplementException(string $property, string $implement, string $got): InvalidArgumentException
    {
        return new InvalidArgumentException(sprintf('%s::%s must be a instance of %s, got %s', get_called_class(), $property, $implement, $got));
    }
}