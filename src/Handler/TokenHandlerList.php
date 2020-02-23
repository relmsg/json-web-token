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

namespace RM\Security\Jwt\Handler;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;
use ReflectionClass;
use ReflectionException;
use RM\Security\Jwt\Token\TokenInterface;

/**
 * Class TokenHandlerList
 *
 * @package RM\Security\Jwt\Handler
 * @author  h1karo <h1karo@outlook.com>
 */
final class TokenHandlerList extends ArrayCollection implements TokenHandlerInterface
{
    /**
     * TokenHandlerList constructor.
     *
     * @param TokenHandlerInterface[] $handlers
     */
    public function __construct(array $handlers = [])
    {
        parent::__construct($handlers);
    }

    /**
     * @inheritDoc
     */
    public function generate(TokenInterface $token): void
    {
        /** @var TokenHandlerInterface $handler */
        foreach ($this as $handler) {
            $handler->generate($token);
        }
    }

    /**
     * @inheritDoc
     */
    public function validate(TokenInterface $token): bool
    {
        /** @var TokenHandlerInterface $handler */
        foreach ($this as $handler) {
            if (!$handler->validate($token)) {
                return false;
            }
        }

        return true;
    }

    public function mergeFromAnnotations(TokenInterface $token): self
    {
        try {
            $list = clone $this;

            $reflect = new ReflectionClass($token);
            $reader = new AnnotationReader();
            $annotations = new ArrayCollection($reader->getClassAnnotations($reflect));
            $annotations
                ->filter(fn(object $annotation) => $annotation instanceof TokenHandlerInterface)
                ->map(fn(TokenHandlerInterface $handler) => $list->add($handler));

            return $list;
        } catch (ReflectionException | AnnotationException $e) {
            return $this;
        }
    }
}