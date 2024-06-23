<?php

use App\Http\Controllers\ContentsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/contents')
    ->name('contents.')
    ->controller(ContentsController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::delete('/{id}', 'destroy')->name('destroy'); // ここで削除メソッドのルートを明示的に追加
    });
