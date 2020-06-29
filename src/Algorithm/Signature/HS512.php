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
    'Class "%s" moved to "%s" package and will be removed in 2.0. Use "%s" instead.',
    HS512::class,
    'relmsg/json-web-signature-hmac'
);

/**
 * Class HS512
 *
 * @author Oleg Kozlov <h1karo@relmsg.ru>
 * @deprecated since relmsg/json-web-token 1.4: Moved to "relmsg/json-web-signature-hmac" package and will be removed in 2.0.
 */
class HS512 extends HMAC
{
    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'HS512';
    }

    /**
     * @inheritDoc
     */
    protected function getHashAlgorithm(): string
    {
        return 'sha512';
    }
}
