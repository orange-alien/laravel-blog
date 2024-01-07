<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class HttpClientLogSubscriber
{
    // リクエストとレスポンスを紐付けるためのUUID
    protected string $uuid = '';

    // リクエスト送信時のログを出力するかどうか
    protected bool $enableLogRequestSending   = false;
    // リクエスト受信時のログを出力するかどうか
    protected bool $enableLogResponseReceived = false;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->uuid = Str::uuid();

        $this->enableLogRequestSending   = config('http_client.enable_log_request_sending');
        $this->enableLogResponseReceived = config('http_client.enable_log_response_received');
    }

    /**
     * subscribe
     *
     * @param  Dispatchers $events
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events) : array
    {
        return [
            RequestSending::class   => 'logRequestSending',
            ResponseReceived::class => 'logResponseReceived',
        ];
    }

    /**
     * リクエスト送信時のログを出力する
     *
     * @param  RequestSending $event
     * @return void
     */
    public function logRequestSending(RequestSending $event) : void
    {
        if(!$this->enableLogRequestSending) {
            return;
        }

        // ログの内容
        $request = $event->request;
        $data = [
            'uuid'    => $this->uuid,
            'event'   => RequestSending::class,
            'request' => $this->requestLog($request),
        ];

        // ログ出力
        $this->writeLog($data);
    }

    /**
     * レスポンス受信時のログを出力する
     *
     * @param  ResponseReceived $event
     * @return void
     */
    public function logResponseReceived(ResponseReceived $event) : void
    {
        if(!$this->enableLogResponseReceived) {
            return;
        }

        // ログの内容
        $request  = $event->request;
        $response = $event->response;
        $data = [
            'uuid'     => $this->uuid,
            'event'    => ResponseReceived::class,
            'request'  => $this->requestLog($request),
            'response' => $this->responseLog($response),
        ];

        // ログ出力
        $response->successful()
            ? $this->writeLog($data)
            : $this->writeLog($data, as:'error');
    }

    /**
     * リクエスト送信時のログ
     *
     * @param  Request $request
     * @return array
     */
    protected function requestLog(Request $request) : array
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

    /**
     * レスポンス受信時のログ
     *
     * @param  Response $response
     * @return array
     */
    protected function responseLog(Response $response) : array
    {
        return [
            'status' => $response->status(),
            'body'   => json_decode($response->body(), true),
        ];
    }

    /**
     * ログ出力
     *
     * @param  array $logData
     * @param  string $as
     * @return void
     */
    protected function writeLog(array $logData, string $as = 'info'): void
    {
        logs()->channel('http_client')->{$as}( json_encode($logData, JSON_UNESCAPED_UNICODE) );
    }
}
