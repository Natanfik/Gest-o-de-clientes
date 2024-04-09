<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteControladora;
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
    return view('cadastro');
});

Route::resource('cliente', ClienteControladora::class);
