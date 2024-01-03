<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        // カウント(期待した結果にならない)
        // SQL : "select `users`.`id`, COUNT(*) as count from `users` inner join `posts` on `users`.`id` = `posts`.`user_id` group by `users`.`id`" 
        // 出力 : 1 ... 7 になって欲しい
        $query = DB::table('users')->select(
            'users.id',
            DB::raw('COUNT(*) as count'),
        )
        ->join('posts', 'users.id', '=', 'posts.user_id')
        ->groupBy('users.id');
        dump($query->toRawSql());
        dump($query->count());

        // カウント(期待通りの結果になる)
        // SQL : select distinct `user_id` from `posts`;
        // 出力 : 7
        $query2 = DB::table('posts')->select('user_id')->distinct('user_id');
        dump($query2->toRawSql());
        dd($query2->count());

        return null;
    }
}
