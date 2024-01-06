<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    // 取得
    public function index()
    {
        $query = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];
        $response = Http::asJson()->get('https://httpbin.org/get', $query);
    }

    // 登録
    public function post()
    {
        $parameters = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];
        $response = Http::asJson()->post('https://httpbin.org/post', $parameters);
    }

    // 更新
    public function put()
    {
        $parameters = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];
        $response = Http::asJson()->put('https://httpbin.org/put', $parameters);
    }

    // 削除
    public function delete()
    {
        $response = Http::asJson()->delete('https://httpbin.org/delete');
    }

    // JSON
    public function json()
    {
        $response = Http::asJson()->get('https://httpbin.org/json');
    }

    // エラー
    public function error(int $code)
    {
        $response = Http::asJson()->get("https://httpbin.org/status/{$code}");
    }
}
