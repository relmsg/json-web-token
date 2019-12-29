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

namespace RM\Security\Jwt\Key;

/**
 * Class OctetKey
 *
 * @package RM\Security\Jwt\Key
 * @author  h1karo <h1karo@outlook.com>
 */
final class OctetKey extends AbstractKey
{
    /**
     * OctetKey constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        parent::__construct([
            self::PARAM_KEY_TYPE  => self::KEY_TYPE_OCTET,
            self::PARAM_KEY_VALUE => $value
        ]);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->get(self::PARAM_KEY_VALUE);
    }
}