<?php

namespace App\Listeners;

use App\Libs\Traits\HttpClientLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Request;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class LogRequestSending
{
    use HttpClientLog;

    // リクエスト送信時のログを出力するかどうか
    protected bool $requestSendingLogEnabled = false;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->requestSendingLogEnabled = config('api_log.request_sending_log_enabled');
    }

    /**
     * Handle the event.
     */
    public function handle(RequestSending $event): void
    {
        if(!$this->requestSendingLogEnabled) {
            return;
        }

        // ログの内容
        $request = $event->request;
        $data = [
            'event'   => RequestSending::class,
            'request' => $this->requestSendingLogData($request),
        ];

        // ログ出力
        $this->writeLog($data);
    }

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
}
