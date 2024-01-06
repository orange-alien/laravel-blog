<?php

namespace App\Providers;

use App\Listeners\LogRequestSending;
use App\Listeners\LogResponseReceived;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class HttpClientLogServiceProvider extends ServiceProvider
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
        // リクエストとレスポンスを一意に紐付けるためのUUID
        $uuid = Str::uuid();

        $this->app->when(LogRequestSending::class)
            ->needs('$uuid')
            ->give($uuid);
        $this->app->when(LogResponseReceived::class)
            ->needs('$uuid')
            ->give($uuid);
    }
}
