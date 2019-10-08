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

namespace RM\Security\Jwt\Storage;

use Redis;
use InvalidArgumentException;

/**
 * Class RedisTokenStorage
 *
 * @package RM\Security\Jwt\Storage
 * @author  h1karo <h1karo@outlook.com>
 */
class RedisTokenStorage implements TokenStorageInterface
{
    /**
     * @var string
     */
    private $host;
    /**
     * @var int
     */
    private $port;
    /**
     * @var float
     */
    private $timeout;
    /**
     * @var Redis
     */
    private $redis;

    /**
     * RedisTokenStorage constructor.
     *
     * @param string $host
     * @param int    $port
     * @param float  $timeout
     */
    public function __construct(string $host, int $port = 6379, float $timeout = 0.0)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;

        if (class_exists(Redis::class, false)) {
            $this->redis = new Redis();
            $this->redis->connect($host, $port, $timeout);
        } else {
            throw new InvalidArgumentException("Redis class is not found. Maybe you should install redis php extension.");
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
        return $this->redis->get($tokenId) === $tokenId;
    }

    /**
     * Adds token id in storage on some duration (ttl)
     *
     * @param string $tokenId
     * @param int    $duration
     */
    public function put(string $tokenId, int $duration): void
    {
        $this->redis->set($tokenId, $tokenId, $duration);
    }

    /**
     * Revokes token
     *
     * @param string $tokenId
     */
    public function revoke(string $tokenId): void
    {
        $this->redis->del($tokenId);
    }
}