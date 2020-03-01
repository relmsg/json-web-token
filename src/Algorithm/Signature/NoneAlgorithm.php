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
     * @inheritDoc
     */
    public function name(): string
    {
        return 'none';
    }

    /**
     * @inheritDoc
     */
    public function allowedKeyTypes(): array
    {
        return ['oct'];
    }

    /**
     * @inheritDoc
     */
    public function hash(KeyInterface $key, string $input): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function verify(KeyInterface $key, string $input, string $hash): bool
    {
        return $this->hash($key, $input) === $hash;
    }
}