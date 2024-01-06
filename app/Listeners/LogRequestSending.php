<?php

namespace App\Listeners;

use App\Libs\Traits\HttpClientRequestSendingLog;
use App\Libs\Traits\WritesHttpClientLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Request;
use Illuminate\Queue\InteractsWithQueue;

class LogRequestSending
{
    use HttpClientRequestSendingLog;
    use WritesHttpClientLog;

    // リクエスト送信時のログを出力するかどうか
    protected bool $requestSendingLogEnabled = false;

    /**
     * Create the event listener.
     */
    public function __construct(protected string $uuid)
    {
        $this->requestSendingLogEnabled = config('api.request_sending_log_enabled');
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
            'uuid'    => $this->uuid,
            'event'   => RequestSending::class,
            'request' => $this->requestSendingLog($request),
        ];

        // ログ出力
        $this->writeLog($data);
    }


}
