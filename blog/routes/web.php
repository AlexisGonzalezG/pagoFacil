<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pagoFacil;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/index', 'pagoFacil\pagoFacil_controller@index')->name('index');
Route::post('/transaccion', 'pagoFacil\pagoFacil_controller@transaccion');
Route::post('/get_transaccions', 'pagoFacil\pagoFacil_controller@get_transaccions');
Route::post('/delete_transaccion', 'pagoFacil\pagoFacil_controller@delete_transaccion');
Route::get('/transaccion_id/{id}', 'pagoFacil\pagoFacil_controller@transaccion_id');