<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ApiController;

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

Route::prefix('/versions')->name('versions.')->group(function () {
    Route::get('/1', [ApiController::class, 'simpleMessage'])->name('1');
    Route::get('/2', [ApiController::class, 'tailorMadeMessage'])->name('2');
    Route::get('/3', [ApiController::class, 'elderPictureMessage'])->name('3');
    Route::get('/4-1', [ApiController::class, 'simpleMessageWithFullName'])->name('4-1');
    Route::get('/5', [ApiController::class, 'simpleMessageButDifferentFormat'])->name('5');
});

Route::prefix('/members')->name('members.')->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('index');
    Route::post('/', [MemberController::class, 'store'])->name('store');
    Route::delete('/{id}', [MemberController::class, 'destroy'])->name('destroy');
});
