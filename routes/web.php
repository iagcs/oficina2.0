<?php

use App\Http\Controllers\orcamentoController;
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
    return view('welcome');
});

Route::get('/orcamentos',[orcamentoController::class, 'index']);
Route::get('/orcamentos/create',[orcamentoController::class, 'create']);
Route::post('/orcamentos/store',[orcamentoController::class, 'store']);
Route::get('/orcamentos/edit/{id}',[orcamentoController::class, 'edit']);
Route::post('/orcamentos/edit/{id}',[orcamentoController::class, 'update']);
Route::get('/orcamentos/filtro/{cliente?}{vendedor?}{dataInicio?}{dataFim?}',[orcamentoController::class, 'search']);
Route::delete('/orcamentos/delete/{id}',[orcamentoController::class, 'destroy']);
