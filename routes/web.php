<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\tokencontroller;
use App\Http\Controllers\mailserver;

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

Route::get('/',[tokencontroller::class,'home'])->name('home');
Route::post('/get-token',[tokencontroller::class,'generateToken'])->name('generateToken');
Route::get('/get-token',[tokencontroller::class,'getToken'])->name('getToken');
Route::post('sendMail',[mailserver::class,'sendMail']);
