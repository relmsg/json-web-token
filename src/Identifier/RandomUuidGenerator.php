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

namespace RM\Standard\Jwt\Identifier;

use Exception;
use InvalidArgumentException;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid;

/**
 * Class RandomUuidGenerator provides UUID v4 via ramsey\uuid package.
 *
 * @package RM\Standard\Jwt\Identifier
 * @author  h1karo <h1karo@outlook.com>
 */
final class RandomUuidGenerator implements IdentifierGeneratorInterface
{
    /**
     * @return string
     * @throws UnsatisfiedDependencyException
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}