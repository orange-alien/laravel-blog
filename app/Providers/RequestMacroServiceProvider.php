<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class RequestMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // int もしくは null を返す
        Request::macro('integerOrNull', function (string $key, $default = null) {
            $value = $this->get($key, $default);
            return is_null($value) ? null : intVal($value);
        });
    }
}
