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

use InvalidArgumentException;
use ParagonIE\ConstantTime\Base64UrlSafe;
use RM\Security\Jwt\Key\KeyInterface;

/**
 * Class HMAC
 *
 * @package RM\Security\Jwt\Signature
 * @author  h1karo <h1karo@outlook.com>
 */
abstract class HMAC implements SignatureAlgorithmInterface
{
    /**
     * {@inheritDoc}
     */
    final public function allowedKeyTypes(): array
    {
        return ['oct'];
    }

    /**
     * {@inheritDoc}
     */
    final public function hash(KeyInterface $key, string $input): string
    {
        $k = $this->getKey($key);
        return hash_hmac($this->getHashAlgorithm(), $input, $k, true);
    }

    /**
     * {@inheritDoc}
     */
    final public function verify(KeyInterface $key, string $input, string $hash): bool
    {
        return hash_equals($this->hash($key, $input), $hash);
    }

    /**
     * @param KeyInterface $key
     *
     * @return string
     */
    protected function getKey(KeyInterface $key): string
    {
        if (!in_array($key->get(KeyInterface::PARAM_KEY_TYPE), $this->allowedKeyTypes(), true)) {
            throw new InvalidArgumentException('Wrong key type.');
        }

        if (!$key->has(KeyInterface::PARAM_KEY_VALUE)) {
            throw new InvalidArgumentException(sprintf("The key parameter '%s' is missing.", KeyInterface::PARAM_KEY_VALUE));
        }

        $k = $key->get(KeyInterface::PARAM_KEY_VALUE);
        if (!is_string($k)) {
            throw new InvalidArgumentException(sprintf("The key parameter '%s' is invalid.", KeyInterface::PARAM_KEY_VALUE));
        }

        return $k;
    }

    /**
     * Returns name of HMAC hash algorithm like "sha256"
     *
     * @return string
     */
    abstract protected function getHashAlgorithm(): string;
}