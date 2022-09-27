<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::post('create-board', [App\Http\Controllers\GameController::class, 'createBoard'])->name('create-board');

Route::get('reset-board', [App\Http\Controllers\GameController::class, 'resetBoard'])->name('reset-board');

Route::post('check-match', [App\Http\Controllers\GameController::class, 'checkMatch'])->name('check-match');
