<?php

namespace App\Libs\Traits;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

trait HttpClientLog
{
    // リクエスト送信時の内容
    protected function requestSendingLogData(Request $request) : array
    {
        return [
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
            'status' => $response->status(),
            'body'   => json_decode($response->body(), true),
        ];
    }

    // ログの書き込み
    protected function writeLog(array $logData, string $as = 'info'): void
    {
        logs()->channel('api_log')->{$as}( json_encode($logData, JSON_UNESCAPED_UNICODE) );
    }
}