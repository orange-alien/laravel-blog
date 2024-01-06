<?php

namespace App\Listeners\Traits;

use Illuminate\Http\Client\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

trait RequestLog
{
    // リクエスト送信時の内容
    protected function requestLog(Request $request) : array
    {
        return [
            'method'  => $request->method(),
            'url'     => $request->url(),
            'headers' => $request->headers(),
            'body'    => json_decode($request->body(), true),
            'query'   => $request->method() === SymfonyRequest::METHOD_GET
                            ? $request->data()
                            : [],
        ];
    }
}