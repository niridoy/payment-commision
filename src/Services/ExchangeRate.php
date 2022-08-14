<?php

declare(strict_types=1);

namespace Payment\Commission\Services;

use Payment\Commission\Services\APIExchangeRate;

class ExchangeRate
{

    private static $instance;

    private function __construct()
    {
        // Private to disabled instantiation.
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new APIExchangeRate;
        }

        return static::$instance;
    }

    final public function __clone()
    {
       throw new \Exception('Feature disabled.');
    }

    final public function __wakeup()
    {
       throw new \Exception('Feature disabled.');
    }
}
