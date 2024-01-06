<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

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

    // レスポンス受信時のログ
    protected function responseReceivedLogData(Response $response) : array
    {
        return [
            'event' => 'response.received',
            'body'  => json_decode($response->body(), true),
        ];
    }

    // ログの書き込み
    protected function writeLog(array $logData, string $as = 'info'): void
    {
        logs()->channel('api_log')->{$as}( json_encode($logData, JSON_UNESCAPED_UNICODE) );
    }
}
