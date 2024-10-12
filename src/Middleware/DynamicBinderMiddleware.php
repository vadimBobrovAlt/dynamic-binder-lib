<?php

namespace bobrovva\dynamic_binder_lib\Middleware;

use App\Infrastructure\DynamicBinder\DynamicBinderConditionResolver;
use bobrovva\dynamic_binder_lib\Helpers\ImplementationHelper;
use Closure;
use Illuminate\Http\Request;

/**
 * Class DynamicBinderMiddleware
 *
 * Middleware для динамической привязки интерфейсов к реализациям на основе условия,
 * получаемого от `DynamicBinderConditionResolver`.
 *
 * Этот middleware отвечает за привязку реализаций интерфейсов к соответствующим классам
 * в зависимости от условий, основанных на ролях пользователя или других факторов.
 */
class DynamicBinderMiddleware
{
    /**
     * Обрабатывает входящий запрос и выполняет привязку интерфейсов к реализациям.
     *
     * Этот метод получает условие, используя класс `DynamicBinderConditionResolver`,
     * затем производит привязку интерфейсов из конфигурации `bindings`.
     *
     * @param \Illuminate\Http\Request $request  Входящий HTTP запрос.
     * @param \Closure $next                Замыкание для передачи управления следующему элементу middleware.
     *
     * @return \Illuminate\Http\Response       Ответ, возвращаемый из middleware.
     */
    public function handle(Request $request, Closure $next)
    {
        $condition = DynamicBinderConditionResolver::resolve();

        $bindings = config('bindings');
        foreach ($bindings as $interface => $bind) {
            ImplementationHelper::bind($interface, $condition);
        }

        return $next($request);
    }
}