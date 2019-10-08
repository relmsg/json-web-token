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

namespace RM\Security\Jwt\Algorithm\Signature;

use RM\Security\Jwt\Key\KeyInterface;

/**
 * Class NoneAlgorithm
 *
 * @package RM\Security\Jwt\Algorithm\Signature
 * @author  h1karo <h1karo@outlook.com>
 */
class NoneAlgorithm implements SignatureAlgorithmInterface
{
    /**
     * {@inheritDoc}
     */
    public function name(): string
    {
        return "none";
    }

    /**
     * {@inheritDoc}
     */
    public function allowedKeyTypes(): array
    {
        return ['oct'];
    }

    /**
     * {@inheritDoc}
     */
    public function hash(KeyInterface $key, string $input): string
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function verify(KeyInterface $key, string $input, string $hash): bool
    {
       return $this->hash($key, $input) === $hash;
    }
}