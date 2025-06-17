<?php

use App\Models\Clientes;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteControladora;
use App\Http\Controllers\PresencaController;

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
    return view('inicio');
});

// Rotas do Cliente


Route::get('/presenca/api/{data}', [PresencaController::class, 'carregarPresencas']);
Route::get('/clientes/{cliente}/pacotes', [ClienteControladora::class, 'pacotes'])->name('cliente.pacotes');
Route::post('/clientes/store-pacotes', [ClienteControladora::class, 'storePacotes'])->name('cliente.storePacotes');
Route::post('/clientes/dados-pessoais', [ClienteControladora::class, 'storeDadosPessoais'])->name('cliente.storeDadosPessoais');
Route::get('/clientes', [ClienteControladora::class, 'index'])->name('cliente.index');
Route::get('/clientes/create', [ClienteControladora::class, 'create'])->name('cliente.create');
Route::post('/clientes', [ClienteControladora::class, 'store'])->name('cliente.store');
Route::get('clientes/{id}', [ClienteControladora:: class, 'show'])->name('cliente.show');
Route::get('/clientes/{cliente}/edit', [ClienteControladora::class, 'edit'])->name('cliente.edit');
Route::put('/clientes/{cliente}', [ClienteControladora::class, 'update'])->name('cliente.update');
Route::delete('/clientes/{cliente}', [ClienteControladora::class, 'destroy'])->name('cliente.destroy');

Route::get('/presenca', [PresencaController::class, 'index'])->name('presenca.index');
Route::post('/presenca/entrada', [PresencaController::class, 'registrarEntrada'])->name('presenca.entrada');
Route::post('/presenca/saida', [PresencaController::class, 'registrarSaida'])->name('presenca.saida');
Route::get('/presenca/{data}', [PresencaController::class, 'carregarPresencas']);
