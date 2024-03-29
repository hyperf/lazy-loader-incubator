中文 | [English](./README-en.md)

# Hyperf di 延迟加载

```
composer require hyperf/lazy-loader-incubator
```

## 发布配置文件

```shell
php bin/hyperf vendor:publish hyperf/lazy-loader-incubator
```

## 使用

```php
// app/Service/UserInterface
interface UserInterface {
    public function work();
}
// app/Service/UserService
class UserService implements UserInterface{
    public function work() 
    {
        return 'working...';
    }
}
```

```php
// app/Controller/IndexController
namespace App\Controller;

use App\Service\UserInterface;
use Hyperf\Di\Annotation\Inject;

class IndexController {
    #[Inject(lazy: true)]
    private UserInterface $userService;
    
    public function index() {
        return $this->userService->work();
    }
}
```

生成延迟代理类为

```php
// runtime/container/proxy/Hyperf_Lazy_UserService_xxx.php
namespace HyperfLazy\UserService;

/**
 * Be careful: This is a lazy proxy, not the real HyperfTest\Stub\FooService from container.
 *
 * {@inheritdoc}
 */
class Foo extends \App\Service\UserService
{
    use \Hyperf\Di\LazyLoader\LazyProxyTrait;
    const PROXY_TARGET = 'HyperfTest\\Stub\\FooService';
    public function work()
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }
}
```