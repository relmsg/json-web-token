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

namespace RM\Security\Jwt\Service;

use RM\Security\Jwt\Algorithm\AlgorithmManager;
use RM\Security\Jwt\Storage\TokenStorageInterface;

/**
 * Interface TokenServiceInterface
 *
 * @package RM\Security\Jwt\Service
 * @author  h1karo <h1karo@outlook.com>
 */
interface TokenServiceInterface
{
    /**
     * @return AlgorithmManager
     */
    public function getAlgorithmManager(): AlgorithmManager;

    /**
     * Returns token storage for token id
     *
     * @return TokenStorageInterface
     */
    public function getTokenStorage(): ?TokenStorageInterface;
}