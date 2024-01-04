<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestController extends Controller
{
    // new したとき
    public function new()
    {
        $user = new User();
        dump($user->wasRecentlyCreated); // false
    }

    // first() のとき
    public function first()
    {
        $user = User::first();
        dump($user->wasRecentlyCreated); // false
    }

    // create() のとき
    public function create()
    {
        $name = Str::random();
        $user = User::create(
            [
                'name'     => $name,
                'email'    => "{$name}@example.com",
                'password' => Hash::make('password'),
            ]
        );
        dump($user->wasRecentlyCreated); // true
    }

    // save() のとき(新規作成時)
    public function save()
    {
        $user = new User();

        $name = Str::random();
        $user->fill([
            'name'     => $name,
            'email'    => "{$name}@example.com",
            'password' => Hash::make('password'),
        ])
        ->save();
        dump($user->wasRecentlyCreated); // true
    }

    // save() のとき(更新時)
    public function save2()
    {
        $user = User::first();
        $user->fill([
            'name' => Str::random(),
        ])
        ->save();
        dump($user->wasRecentlyCreated); // false
    }
}
