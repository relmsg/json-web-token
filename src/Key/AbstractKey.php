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

namespace RM\Security\Jwt\Key;

use InvalidArgumentException;

/**
 * Class AbstractKey
 *
 * @package RM\Security\Jwt\Key
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class AbstractKey implements KeyInterface
{
    private array $parameters = [];

    /**
     * Key constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        if (!array_key_exists(self::PARAM_KEY_TYPE, $parameters)) {
            throw new InvalidArgumentException(sprintf("Any JSON Web Key must have the key type parameter (`%s`).", self::PARAM_KEY_TYPE));
        }

        $this->parameters = $parameters;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $parameter): string
    {
        if (!$this->has($parameter)) {
            throw new InvalidArgumentException(sprintf("The parameter with name `%s` is not exists in this key.", $parameter));
        }

        return $this->parameters[$parameter];
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $parameter): bool
    {
        return array_key_exists($parameter, $this->parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->parameters;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): array
    {
        return $this->parameters;
    }
}