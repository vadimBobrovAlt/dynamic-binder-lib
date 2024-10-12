<?php

namespace App\Infrastructure\DynamicBinder;


class DynamicBinderConditionResolver
{
    /**
     * @return bool Условие, определяющее, какую реализацию использовать.
     */
    public static function resolve(): int|string|bool
    {
        return true;
    }
}