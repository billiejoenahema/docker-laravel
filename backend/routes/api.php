<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginUserController;
use App\Http\Controllers\Api\MemoController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // ログインユーザー
    Route::get('/login_user', LoginUserController::class);
    // メモ
    Route::get('/memos', [MemoController::class, 'index']);
    Route::post('/memos', [MemoController::class, 'store']);
    Route::patch('/memos/{memo}', [MemoController::class, 'update']);
    Route::delete('/memos/{memo}', [MemoController::class, 'destroy']);
    // タグ
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::patch('/tags/{tag}', [TagController::class, 'update']);
});
