<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('/test')->group(function() {
    // 動作検証を容易にするために GET で登録や更新を行っているが、
    // 本来は POST や PUT を用いるべきである。
    Route::get('/new',    [TestController::class, 'new']);
    Route::get('/first',  [TestController::class, 'first']);
    Route::get('/create', [TestController::class, 'create']);
    Route::get('/save',   [TestController::class, 'save']);
    Route::get('/save2',  [TestController::class, 'save2']);
});