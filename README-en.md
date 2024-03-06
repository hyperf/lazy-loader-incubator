[中文](./README.md) | English

# Hyperf di delayed loading

```
composer require hyperf/lazy-loader-incubator
```

## Publishing Configuration Files

```shell
php bin/hyperf vendor:publish hyperf/lazy-loader-incubator
```

## make use of

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

Generate the deferred proxy class as

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