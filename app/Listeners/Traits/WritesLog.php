<?php

namespace App\Listeners\Traits;

trait WritesLog
{
    // ログ出力
    protected function writeLog(array $logData, string $as = 'info'): void
    {
        logs()->channel('api_log')->{$as}( json_encode($logData, JSON_UNESCAPED_UNICODE) );
    }
}