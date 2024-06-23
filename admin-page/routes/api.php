<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecommendController;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('recommend', RecommendController::class);


// 書籍に関連するルートをグループ化
Route::prefix('books')
    ->name('books.')
    ->controller(BookController::class)
    ->group(function () {
        Route::get('/', 'getAllBooks')->name('getAllBooks');
        Route::post('/', 'storeBook')->name('storeBook');
        Route::get('{book}', 'getBookDetail')->name('getBookDetail');
        Route::put('{book}', 'editBookDetail')->name('editBookDetail');
        Route::delete('{book}', 'deleteBook')->name('deleteBook');
        Route::get('search', 'search')->name('search');
        Route::post('{book}/borrow', 'borrow')->name('borrow');
        Route::post('{book}/return', 'returnBook')->name('return');
    });
