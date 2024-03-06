<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace HyperfTest\Stub;

use Mockery;
use Psr\Log\LoggerInterface;

class FooService implements FooServiceInterface
{
    public function getLogger(): LoggerInterface
    {
        return Mockery::mock(LoggerInterface::class);
    }

    public function foo(): string
    {
        return 'foo';
    }
}
