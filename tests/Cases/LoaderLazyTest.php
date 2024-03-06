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

namespace HyperfTest\Cases;

use Hyperf\Di\LazyLoader\LazyLoader;
use HyperfTest\Stub\BarService;
use HyperfTest\Stub\FooService;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class LoaderLazyTest extends TestCase
{
    public function testGeneratorLazyProxyInterface()
    {
        $lazyLoader = LazyLoader::bootstrap(BASE_PATH);
        $proxyCode = file_get_contents(__DIR__ . '/FooService.txt');
        $code = $lazyLoader->generatorLazyProxy('HyperfLazy\\Foo\\', FooService::class);
        self::assertEquals($proxyCode, $code);
    }

    public function testGeneratorLazyProxyClass()
    {
        $lazyLoader = LazyLoader::bootstrap(BASE_PATH);
        $proxyCode = file_get_contents(__DIR__ . '/BarService.txt');
        $code = $lazyLoader->generatorLazyProxy('HyperfLazy\\Test\\', BarService::class);
        self::assertEquals($proxyCode, $code);
    }
}
