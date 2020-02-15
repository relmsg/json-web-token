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

namespace RM\Security\Jwt\Tests\Serializer;

use Generator;
use PHPUnit\Framework\TestCase;
use RM\Security\Jwt\Algorithm\Signature\Keccak512;
use RM\Security\Jwt\Exception\InvalidTokenException;
use RM\Security\Jwt\Serializer\SignatureCompactSerializer;
use RM\Security\Jwt\Token\SignatureToken;
use RM\Security\Jwt\Token\TokenInterface;
use stdClass;

class SignatureCompactSerializerTest extends TestCase
{
    public function testSupports()
    {
        $serializer = new SignatureCompactSerializer(SignatureToken::class);

        $this->assertTrue($serializer->supports(SignatureToken::class));
        $this->assertFalse($serializer->supports(stdClass::class));

        $token = SignatureToken::createWithAlgorithm(new Keccak512());
        $this->assertTrue($serializer->supports($token));
        $this->assertFalse($serializer->supports(new stdClass()));

        return $serializer;
    }

    /**
     * @depends      testSupports
     * @dataProvider getTokens
     *
     * @param bool                       $isValid
     * @param string                     $rawToken
     * @param SignatureCompactSerializer $serializer
     *
     * @return TokenInterface
     * @throws InvalidTokenException
     */
    public function testSerialize(
        bool $isValid,
        string $rawToken,
        SignatureCompactSerializer $serializer
    ): TokenInterface {
        if (!$isValid) {
            $this->expectException(InvalidTokenException::class);
        }

        $token = $serializer->deserialize($rawToken);
        $this->assertInstanceOf(SignatureToken::class, $token);

        $serializedToken = $token->toString($serializer);
        $this->assertNotNull($serializedToken);
        $this->assertEquals($rawToken, $serializedToken);

        return $token;
    }

    public function getTokens(): Generator
    {
        yield [
            true,
            'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c'
        ];
        yield [false, 'eyJhbGciOiJIUzI1NiJ9.SGVsbG8sIHdvcmxkIQ.onO9Ihudz3WkiauDO2Uhyuz0Y18UASXlSc1eS0NkWyA'];
        yield [false, 'this.is.invalid.token'];
    }
}
