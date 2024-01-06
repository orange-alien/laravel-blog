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

        $logData = $this->logData($request);
        $this->writeLog($logData);
    }

    // ログの内容
    protected function logData(Request $request) : array
    {
        return [
            'event'   => 'request.sending',
            'request' => $this->requestSendingLogData($request),
        ];
    }
}
