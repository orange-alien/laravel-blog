<?php

namespace App\Listeners;

use App\Libs\Traits\HttpClientLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Queue\InteractsWithQueue;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;


class LogResponseReceived
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
    public function handle(ResponseReceived $event): void
    {
        $request  = $event->request;
        $response = $event->response;

        $logData = [
            'request'  => $this->requestSendingLogData($request),
            'response' => $this->responseReceivedLogData($response),
        ];

        $response->status() === SymfonyResponse::HTTP_OK
            ? $this->writeLog($logData)
            : $this->writeLog($logData, 'error');
    }
}
