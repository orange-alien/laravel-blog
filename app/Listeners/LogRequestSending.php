<?php

namespace App\Listeners;

use App\Libs\Traits\HttpClientLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Request;
use Illuminate\Queue\InteractsWithQueue;

class LogRequestSending
{
    use HttpClientLog;

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
    public function handle(RequestSending $event): void
    {
        $request = $event->request;
        $requestSendingLogData['request'] = $this->requestSendingLogData($request);
        $this->writeLog($requestSendingLogData);
    }
}
