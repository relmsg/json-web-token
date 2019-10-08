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

use InvalidArgumentException;

/**
 * Class AlgorithmManager
 *
 * @package RM\Security\Jwt\Algorithm
 * @author  h1karo <h1karo@outlook.com>
 */
class AlgorithmManager
{
    /**
     * @var AlgorithmInterface[]
     */
    private $algorithms = [];

    /**
     * AlgorithmManager constructor.
     *
     * @param array $algorithms
     */
    public function __construct(array $algorithms = [])
    {
        $this->algorithms = $algorithms;
    }

    /**
     * Returns any algorithm by name
     *
     * @param string $algorithm
     *
     * @return AlgorithmInterface
     */
    public function get(string $algorithm): AlgorithmInterface
    {
        if (!$this->has($algorithm)) {
            throw new InvalidArgumentException(sprintf("The algorithm with name `%s` is not exists in this service.", $algorithm));
        }

        return $this->algorithms[$algorithm];
    }

    /**
     * @param AlgorithmInterface $algorithm
     */
    public function put(AlgorithmInterface $algorithm): void
    {
        $this->algorithms[$algorithm->name()] = $algorithm;
    }

    /**
     * @param string $algorithm
     *
     * @return bool
     */
    public function has(string $algorithm): bool
    {
        return array_key_exists($algorithm, $this->algorithms);
    }

    /**
     * @param string $algorithm
     */
    public function remove(string $algorithm): void
    {
        unset($this->algorithms[$algorithm]);
    }
}