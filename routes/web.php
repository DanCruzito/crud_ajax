<?php

use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::controller(CursoController::class)->group(function(){
  //RUTAS DE CURSOCONTROLLER
  Route::get('curso-index','index')->name('curso.index');
  Route::post('lista-cursos','listar_cursos')->name('curso.lista');
  Route::post('registro-curso','registrar_curso')->name('curso.registrar');
});
