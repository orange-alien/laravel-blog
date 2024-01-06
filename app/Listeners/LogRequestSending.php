<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Request;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class LogRequestSending
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
    public function handle(RequestSending $event): void
    {
        $request = $event->request;
        $requestSendingLogData['request'] = $this->requestSendingLogData($request);
        $this->writeLog($requestSendingLogData);
    }

    // リクエスト送信時の内容
    protected function requestSendingLogData(Request $request) : array
    {
        return [
            'event'   => 'request.sending',
            'method'  => $request->method(),
            'url'     => $request->url(),
            'headers' => $request->headers(),
            'body'    => json_decode($request->body(), true),
            'query'   => $request->method() === SymfonyRequest::METHOD_GET
                            ? $request->data()
                            : null,
        ];
    }

    // ログの書き込み
    protected function writeLog(array $logData, string $as = 'info'): void
    {
        logs()->channel('api_log')->{$as}( json_encode($logData, JSON_UNESCAPED_UNICODE) );
    }
}
