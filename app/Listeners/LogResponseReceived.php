<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Queue\InteractsWithQueue;

class LogResponseReceived
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ResponseReceived $event): void
    {
        //
    }
}
