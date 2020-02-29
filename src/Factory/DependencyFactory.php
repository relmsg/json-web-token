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

namespace RM\Security\Jwt\Factory;

use RM\Security\Jwt\Exception\DependencyBuildException;
use RM\Security\Jwt\Exception\MustImplementException;

/**
 * Class DependencyFactory
 *
 * @package RM\Security\Jwt\Factory
 * @author  h1karo <h1karo@outlook.com>
 */
class DependencyFactory
{
    /**
     * @var object|string|array|null
     */
    private $dependency;
    private ?string $mustImplement = null;

    public function setMustImplement(string $class): self
    {
        $this->mustImplement = $class;
        return $this;
    }

    /**
     * @param object|string|array $dependency
     *
     * @return $this
     */
    public function setDependency($dependency): self
    {
        $this->dependency = $dependency;
        return $this;
    }

    public function build(): object
    {
        if ($this->dependency === null) {
            throw new DependencyBuildException('Dependency can not be null.');
        }

        if (is_object($this->dependency)) {
            $built = $this->dependency;
        } elseif (is_string($this->dependency)) {
            $built = self::buildFromString($this->dependency);
        } elseif (is_array($this->dependency)) {
            $built = self::buildFromArray($this->dependency);
        } else {
            throw new DependencyBuildException(
                sprintf('%s type does not support to create dependency.', gettype($this->dependency))
            );
        }

        if ($this->mustImplement && !$built instanceof $this->mustImplement) {
            throw new MustImplementException($this->mustImplement, get_class($built));
        }

        return $built;
    }

    protected static function buildFromString(string $dependency): object
    {
        return new $dependency();
    }

    protected static function buildFromArray(array $dependency): object
    {
        if (count($dependency) !== 1) {
            throw new DependencyBuildException('Array should have only one value to create dependency.');
        }

        $class = key($dependency);
        $arguments = $dependency[$class];
        return new $class(...$arguments);
    }

    public static function create(): self
    {
        return new static();
    }
}