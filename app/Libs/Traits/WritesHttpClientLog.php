<?php

namespace App\Libs\Traits;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;


trait WritesHttpClientLog
{
    // ログ出力
    protected function writeLog(array $logData, string $as = 'info'): void
    {
        logs()->channel('api_log')->{$as}( json_encode($logData, JSON_UNESCAPED_UNICODE) );
    }
}