<?php

namespace App\Listeners;

use App\Listeners\Traits\RequestLog;
use App\Listeners\Traits\WritesLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Queue\InteractsWithQueue;

class LogRequestSending
{
    use RequestLog;
    use WritesLog;

    // リクエスト送信時のログを出力するかどうか
    protected bool $logEnabled = false;

    /**
     * Create the event listener.
     */
    public function __construct(protected string $uuid)
    {
        $this->logEnabled = config('api.log_request_sending_enabled');
    }

    /**
     * Handle the event.
     */
    public function handle(RequestSending $event): void
    {
        if(!$this->logEnabled) {
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


}
