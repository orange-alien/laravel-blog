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
    Route::get('/index' , [TestController::class, 'index']);
    Route::get('/post'  , [TestController::class, 'post']);
    Route::get('/put'   , [TestController::class, 'put']);
    Route::get('/delete', [TestController::class, 'delete']);
    Route::get('/json'  , [TestController::class, 'json']);
    Route::get('/error/{code}', [TestController::class, 'error']);
});
