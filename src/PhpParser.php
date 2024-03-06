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

use Hyperf\CodeParser\PhpParser as Base;
use PhpParser\Node;
use PhpParser\PrettyPrinter\Standard;
use ReflectionClass;

class PhpParser extends Base
{
    public function getNodesFromReflectionAllClass(ReflectionClass $reflectionClass): ?array
    {
        return $this->parser->parse($this->getReflectionCode($reflectionClass));
    }

    public function getReflectionCode(ReflectionClass $reflectionClass): string
    {
        return (new Standard())->prettyPrintFile($this->getReflectionClassNodes($reflectionClass));
    }

    public function getReflectionClassNodes(ReflectionClass $class)
    {
        $nodes = [];
        $interfaces = $class->getInterfaces() ?: [];
        foreach ($interfaces as $interface) {
            $nodes = array_merge($this->getReflectionClassNodes($interface), $nodes);
        }
        return array_merge($nodes, $this->parser->parse(file_get_contents($class->getFileName())));
    }

    /**
     * @return Node\Stmt\ClassMethod[]
     */
    public function getAllMethodsFromStmts(array $stmts): array
    {
        $methods = [];
        $methodNames = [];
        foreach ($stmts as $namespace) {
            if (! $namespace instanceof Node\Stmt\Namespace_) {
                continue;
            }

            foreach ($namespace->stmts as $class) {
                if (! $class instanceof Node\Stmt\Class_ && ! $class instanceof Node\Stmt\Interface_) {
                    continue;
                }

                foreach ($class->getMethods() as $method) {
                    if (in_array($method->name->name, $methodNames, true)) {
                        continue;
                    }
                    $methodNames[] = $method->name->name;
                    $methods[] = $method;
                }
            }
        }

        return $methods;
    }
}
