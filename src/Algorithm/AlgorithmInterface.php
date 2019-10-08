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

namespace RM\Security\Jwt\Algorithm;

/**
 * Interface AlgorithmInterface
 *
 * @package RM\Security\Jwt\Algorithm
 * @author  h1karo <h1karo@outlook.com>
 */
interface AlgorithmInterface
{
    /**
     * Returns the name of the algorithm.
     *
     * @return string
     */
    public function name(): string;

    /**
     * Returns the key types suitable for this algorithm
     *
     * @return string[]
     */
    public function allowedKeyTypes(): array;
}