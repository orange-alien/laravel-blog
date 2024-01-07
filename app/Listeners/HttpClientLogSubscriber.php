<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Queue\InteractsWithQueue;

class HttpClientLogSubscriber
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
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
        \Log::debug(__METHOD__);
    }

    /**
     * レスポンス受信時のログを出力する
     *
     * @param  ResponseReceived $event
     * @return void
     */
    public function logResponseReceived(ResponseReceived $event) : void
    {
        \Log::debug(__METHOD__);
    }



}
