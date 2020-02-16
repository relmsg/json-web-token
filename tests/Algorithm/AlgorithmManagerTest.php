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

namespace RM\Security\Jwt\Tests\Algorithm;

use PHPUnit\Framework\TestCase;
use RM\Security\Jwt\Algorithm\AlgorithmInterface;
use RM\Security\Jwt\Algorithm\AlgorithmManager;
use RM\Security\Jwt\Algorithm\Signature\HS256;
use RM\Security\Jwt\Algorithm\Signature\HS512;
use RM\Security\Jwt\Algorithm\Signature\Keccak256;
use RM\Security\Jwt\Algorithm\Signature\Keccak512;
use RM\Security\Jwt\Exception\AlgorithmNotFoundException;
use stdClass;
use TypeError;

class AlgorithmManagerTest extends TestCase
{
    private AlgorithmManager $manager;
    private AlgorithmInterface $hs256;
    private AlgorithmInterface $hs512;
    private AlgorithmInterface $keccak256;
    private AlgorithmInterface $keccak512;

    protected function setUp(): void
    {
        $this->hs256 = new HS256();
        $this->hs512 = new HS512();
        $this->keccak256 = new Keccak256();
        $this->keccak512 = new Keccak512();

        $this->manager = new AlgorithmManager();
        $this->manager->put($this->keccak256);
        $this->manager->put($this->keccak512);
    }

    public function testValidConstructor()
    {
        $manager = new AlgorithmManager(
            [
                new HS256()
            ]
        );

        $this->assertInstanceOf(AlgorithmManager::class, $manager);
    }

    public function testInvalidConstructor()
    {
        $this->expectException(TypeError::class);

        new AlgorithmManager(
            [
                new stdClass()
            ]
        );
    }

    public function testValidGet()
    {
        $this->assertEquals($this->keccak256, $this->manager->get($this->keccak256->name()));
    }

    public function testInvalidGet()
    {
        $this->expectException(AlgorithmNotFoundException::class);
        $this->manager->get($this->hs256->name());
    }

    public function testHas()
    {
        $this->assertTrue($this->manager->has($this->keccak256->name()));
        $this->assertFalse($this->manager->has($this->hs256->name()));
    }

    public function testRemove()
    {
        $this->assertTrue($this->manager->has($this->keccak256->name()));
        $this->manager->remove($this->keccak256->name());
        $this->assertFalse($this->manager->has($this->keccak256->name()));
    }

    public function testPut()
    {
        $this->assertFalse($this->manager->has($this->hs512->name()));
        $this->manager->put($this->hs512);
        $this->assertTrue($this->manager->has($this->hs512->name()));
    }
}
