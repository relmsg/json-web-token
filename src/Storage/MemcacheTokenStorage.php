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

namespace RM\Security\Jwt\Storage;

use InvalidArgumentException;
use Memcache;

/**
 * Class MemcacheTokenStorage
 *
 * @package RM\Security\JwtBundle\Storage
 * @author  h1karo <h1karo@outlook.com>
 */
class MemcacheTokenStorage implements TokenStorageInterface
{
    private string   $host;
    private int      $port;
    private Memcache $memcache;

    /**
     * MemcacheTokenStorage constructor.
     *
     * @param string $host
     * @param int    $port
     */
    public function __construct(string $host, int $port = 11211)
    {
        $this->host = $host;
        $this->port = $port;

        if (class_exists(Memcache::class, false)) {
            $this->memcache = new Memcache();
            $this->memcache->addServer($host, $port);
        } else {
            throw new InvalidArgumentException("Memcache class is not found. Maybe you should install memcache php extension.");
        }
    }

    /**
     * Checks if token id exists in storage
     *
     * @param string $tokenId
     *
     * @return bool
     */
    public function has(string $tokenId): bool
    {
        return $this->memcache->get($tokenId) === $tokenId;
    }

    /**
     * Adds token id in storage on some duration (ttl)
     *
     * @param string $tokenId
     * @param int    $duration
     */
    public function put(string $tokenId, int $duration): void
    {
        $this->memcache->set($tokenId, $tokenId, 0, $duration);
    }

    /**
     * Revokes token
     *
     * @param string $tokenId
     */
    public function revoke(string $tokenId): void
    {
        $this->memcache->delete($tokenId);
    }
}