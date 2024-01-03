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
        // SQL : select * from (select `users`.`id`, COUNT(*) as count from `users` inner join `posts` on `users`.`id` = `posts`.`user_id` group by `users`.`id`) as `sub`
        // 出力 : 7
        $query2 = DB::query()->fromSub($query, 'sub');
        dump($query2->toRawSql());
        dump($query2->count());

        // カウント(期待通りの結果になる)
        // SQL : select distinct `user_id` from `posts`;
        // 出力 : 7
        $query3 = DB::table('posts')->select('user_id')->distinct('user_id');
        dump($query3->toRawSql());
        dd($query3->count());

        return null;
    }
}
