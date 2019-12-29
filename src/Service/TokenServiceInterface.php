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