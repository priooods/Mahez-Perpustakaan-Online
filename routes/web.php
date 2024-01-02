<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
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

Route::middleware(['authremove'])->group(function () {
    Route::post('postlogin',[UserController::class,'login']);
    Route::get('register',[UserController::class,'viewRegister']);
    Route::get('/', [UserController::class,'viewLogin'])->name('login');
    Route::resource('user',UserController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::get('logout',[UserController::class,'logout']);
    Route::resource('book',BookController::class);
    Route::resource('category',CategoryController::class);
    Route::post('book/delete/{id}',[BookController::class,'delete']);
    Route::post('book/download/{type}/{id}',[BookController::class,'download']);
    Route::post('book/update/{id}',[BookController::class,'bookupdate']);
    Route::post('book/excel',[BookController::class,'exportExcel']);
    Route::post('category/delete/{id}',[CategoryController::class,'delete']);
    Route::post('category/update/{id}',[CategoryController::class,'categoryupdate']);
});
