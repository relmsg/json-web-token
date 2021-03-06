<?php
/*
 * This file is a part of Relations Messenger Json Web Token Implementation.
 * This package is a part of Relations Messenger.
 *
 * @link      https://github.com/relmsg/json-web-token
 * @link      https://dev.relmsg.ru/packages/json-web-token
 * @copyright Copyright (c) 2018-2020 Relations Messenger
 * @author    Oleg Kozlov <h1karo@relmsg.ru>
 * @license   Apache License 2.0
 * @license   https://legal.relmsg.ru/licenses/json-web-token
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RM\Standard\Jwt\Algorithm\Signature;

trigger_deprecation(
    'relmsg/json-web-token',
    '1.4',
    'Will be removed in 2.0. Using "%s" is deprecated, use "%s" instead.',
    NoneAlgorithm::class,
    None::class
);

/**
 * Class NoneAlgorithm
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 * @deprecated since 1.4, to be removed in 2.0. Use {@see None} instead.
 */
class NoneAlgorithm extends None {}
