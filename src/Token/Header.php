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

namespace RM\Security\Jwt\Token;

use InvalidArgumentException;
use RM\Security\Jwt\Algorithm\AlgorithmInterface;
use RM\Security\Jwt\Algorithm\AlgorithmManager;

/**
 * Class Header
 *
 * @package RM\Security\Jwt\Token
 * @author  h1karo <h1karo@outlook.com>
 */
class Header extends ClaimCollection
{
    /**
     * Algorithm must be set from method { @see AlgorithmInterface::name() } and be in { @see AlgorithmManager }
     */
    public const CLAIM_ALGORITHM = 'alg';
    /**
     * Type of token, by default is `JWT`.
     * If you use some token types please override this claim.
     */
    public const CLAIM_TYPE = 'typ';

    /**
     * Header constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        if (!array_key_exists(self::CLAIM_ALGORITHM, $parameters)) {
            throw new InvalidArgumentException(sprintf("Any JSON Web Token must have the algorithm parameter (`%s`).", self::CLAIM_ALGORITHM));
        }

        parent::__construct($parameters, [
            self::CLAIM_ALGORITHM => null,
            self::CLAIM_TYPE      => 'JWT'
        ]);
    }
}