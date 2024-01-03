<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestController extends Controller
{
    public function create() : View
    {
        $animals = [
            ['id' => 1, 'name' => 'いぬ'],
            ['id' => 2, 'name' => 'ねこ'],
            ['id' => 3, 'name' => 'とり'],
        ];

        return view('test.create', compact('animals'));
    }

    public function store(Request $request) : RedirectResponse
    {
        // 必ず文字列
        $animalId = $request->get('animal_id');
        dump('$request->get()');
        dump($animalId);
        dump('-----');

        // int が欲しいときは、null でなければ int へのキャストが必要(面倒)
        $animalId = is_null($animalId) ? null : intVal($animalId);
        dump('$request->get() => null でなければ intVal()');
        dump($animalId);
        dump('-----');

        // 必ず int (null は取得できない)
        // default に null を渡しても intVal() でキャストされるため
        $animalId = $request->integer('animal_id', default: null);
        dump('$request->integer()');
        dump($animalId);
        dump('-----');

        // int もしくは null を取得できる
        $animalId = $request->integerOrNull('animal_id');
        dump('$request->integerOrNull()');
        dump($animalId);
        dd('-----');

        return to_route('test.create');
    }
}
