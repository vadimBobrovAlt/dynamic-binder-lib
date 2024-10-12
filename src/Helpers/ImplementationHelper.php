<?php

namespace bobrovva\dynamic_binder_lib\Helpers;

use Illuminate\Support\Facades\App;

class ImplementationHelper
{
    /**
     * Выполняет привязку интерфейса к реализации на основе условия.
     *
     * @param string $interface Интерфейс, который нужно привязать.
     * @param bool $condition Условие, на основании которого выбирается реализация.
     *
     * @return void
     */
    public static function bind(string $interface, bool $condition): void
    {
        $bindings = config('bindings');
        if (isset($bindings[$interface][$condition])) {
            App::bind($interface, $bindings[$interface][$condition]);
        } else {
            throw new \Exception("Привязка для интерфейса $interface не найдена.");
        }
    }

    /**
     * Возвращает экземпляр реализации интерфейса, создавая его через контейнер.
     *
     * @param string $interface Интерфейс, экземпляр которого требуется.
     *
     * @return mixed Экземпляр реализации интерфейса.
     */
    public static function getInstance(string $interface): mixed
    {
        return App::make($interface);
    }
}