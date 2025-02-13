<?php

use App\Http\Controllers\Web\Cursos\CursoController;
use App\Http\Controllers\Web\Estudiantes\EstudianteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
Route::get('/ver-curso', [CursoController::class, 'verCurso'])->name('cursos.ver-curso');
Route::get('/create-update-curso', [CursoController::class, 'createUpdateCurso'])->name('cursos.create-update');

Route::get('/estudiante', [EstudianteController::class, 'index'])->name('estudiante.index');
Route::get('/ver-estudiante', [EstudianteController::class, 'verEstudiante'])->name('estudiante.ver-estudiante');
Route::get('/create-update-estudiante', [EstudianteController::class, 'createUpdateEstudiante'])->name('estudiante.create-update');

