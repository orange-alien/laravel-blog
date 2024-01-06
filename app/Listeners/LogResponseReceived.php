<?php

namespace App\Listeners;

use App\Listeners\Traits\RequestLog;
use App\Listeners\Traits\WritesLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Queue\InteractsWithQueue;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;


class LogResponseReceived
{
    use RequestLog;
    use WritesLog;

    // レスポンス受信時のログを出力するかどうか
    protected bool $responseReceivedLogEnabled = false;

    /**
     * Create the event listener.
     */
    public function __construct(protected string $uuid)
    {
        $this->responseReceivedLogEnabled = config('api.response_received_log_enabled');
    }

    /**
     * Handle the event.
     */
    public function handle(ResponseReceived $event): void
    {
        if(!$this->responseReceivedLogEnabled) {
            return;
        }

        // ログの内容
        $request  = $event->request;
        $response = $event->response;
        $data = [
            'uuid'    => $this->uuid,
            'event'    => ResponseReceived::class,
            'request'  => $this->requestLog($request),
            'response' => $this->responseLog($response),
        ];

        // ログ出力
        $response->status() === SymfonyResponse::HTTP_OK
            ? $this->writeLog($data)
            : $this->writeLog($data, as:'error');
    }

    // レスポンス受信時の内容
    protected function responseLog(Response $response) : array
    {
        return [
            'status' => $response->status(),
            'body'   => json_decode($response->body(), true),
        ];
    }

}
