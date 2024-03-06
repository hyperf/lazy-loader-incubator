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

namespace Hyperf\Di\LazyLoader;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
                'class_map' => [
                    LazyLoader::class => __DIR__ . '/LazyLoader.php',
                    PublicMethodVisitor::class => __DIR__ . '/PublicMethodVisitor.php',
                ],
            ],
            'publish' => [
                [
                    'id' => 'lazy_config',
                    'description' => 'Lazy Loading Configuration',
                    'source' => dirname(__DIR__) . '/publish/lazy_loader.php',
                    'destination' => BASE_PATH . '/config/lazy_loader.php',
                ],
            ],
        ];
    }
}
