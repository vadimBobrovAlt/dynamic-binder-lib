# Dynamic Binder Middleware

## Что делает библиотека

`Dynamic Binder Middleware` — это библиотека для Laravel, позволяющая динамически привязывать интерфейсы к реализациям в
зависимости от условий, основанных на контексте, например, ролях пользователя. Это упрощает управление зависимостями и
улучшает модульность кода.

## Установка

1. **Добавьте библиотеку в проект:**

   Скопируйте файлы библиотеки в ваш проект или используйте Composer для установки, если библиотека доступна в
   репозитории:

   ```bash
   composer require bobrovva/dynamic-binder
   ```

2. **Добавьте конфигурационный файл:**

   Если необходимо, создайте файл конфигурации `config/bindings.php` для определения привязок интерфейсов:

   ```php
   return [
       TestServiseInterface::class => [
           'admin' => AdminTestServise::class,
           'owner' => OwnerTestServise::class,
       ],
        TestRepositoryInterface::class => [
           'admin' => AdminTestRepository::class,
           'owner' => OwnerTestRepository::class,
       ]
   ];
   ```

3. **Зарегистрируйте Middleware:**

   Добавьте `DynamicBinderMiddleware` в файл `app/Http/Kernel.php`:

   ```php
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(DynamicBinderMiddleware::class);
    })
   ```

## Пример использования

### 1 Определите интерфейсы и реализации

```php
namespace App\Contracts;

interface TestServiceInterface
{
    public function test(): string;
}
```

```php
namespace App\Implementations;

use App\Contracts\TestServiceInterface;

class AdminTestService implements TestServiceInterface
{
    public function test(): string
    {
        return 'AdminTest';
    }
}

class OwnerTestService implements TestServiceInterface
{
    public function test(): string
    {
        return 'OwnerTest';
    }
}
```

### 2 Создайте класс для разрешения условия

```php
class DynamicBinderConditionResolver
{
    public static function resolve(): mixed
    {
        return auth()->user()->roles[0];
    }
}
```

### 3.1 Использование (1 Вариант)

```php
    public function __construct(protected Interface $interface)
    {
        
    }
    
    public function index()
    {
        $this->interface->test()
    }
```

### 3.1 Использование (2 Вариант)

```php
    protected Interface $interface;

    public function __construct()
    {
        ImplementationHelper::bind(Interface::class, auth()->user()->roles[0]);
        $this->interface = ImplementationHelper::getInstance(Interface::class);
    }
```