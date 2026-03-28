<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// login
Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
Route::post('/login', [AuthController::class, 'saveLogin'])->name('save.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [AuthController::class, 'indexLogin']);

Route::get('/register', [AuthController::class, 'indexRegister'])->name('index.register');
Route::post('/register', [AuthController::class, 'saveRegister'])->name('save.register');

Route::middleware(['auth'])->group(function () {
    // rutas estudiante
    Route::get('/dashbordUser', [UserController::class, 'indexUser'])->name('index.user');
    Route::get('/inscritas', [UserController::class, 'myInscripciones'])->name('my.inscripciones');
    Route::get('/mis-actividades/{grupo_id}', [UserController::class, 'verActividades'])->name('ver.actividades');
    Route::get('/actividad-detalles/{actividad_id}', [UserController::class, 'verDetallesActividad'])->name('ver.detallesActividad');
    Route::post('/entregar-actividad', [UserController::class, 'saveEntrega'])->name('save.entrega');
    Route::post('/inscribir', [UserController::class, 'saveInscripcion'])->name('save.inscripcion');
    Route::delete('/donde-baja', [UserController::class, 'deleteInscripcion'])->name('delete.my.inscripcion');

    // rutas profesor
    Route::get('/dashProf', [App\Http\Controllers\ProfesorController::class, 'indexProfesor'])->name('index.profesor');
    Route::get('/grupo-alumnos/{grupo_id}', [App\Http\Controllers\ProfesorController::class, 'verAlumnos'])->name('profesor.alumnos');
    Route::get('/grupo-actividades/{grupo_id}', [App\Http\Controllers\ProfesorController::class, 'verActividades'])->name('profesor.actividades');
    Route::get('/actividad-entregas/{actividad_id}', [App\Http\Controllers\ProfesorController::class, 'verEntregas'])->name('profesor.entregas');
    Route::post('/save-actividad', [App\Http\Controllers\ProfesorController::class, 'saveActividad'])->name('save.actividad');
    Route::post('/tarea-calificacion', [App\Http\Controllers\ProfesorController::class, 'saveTareaCalificacion'])->name('profesor.saveTareaCalificacion');
    Route::post('/save-calificacion', [App\Http\Controllers\ProfesorController::class, 'saveCalificacion'])->name('profesor.saveCalificacion');
    Route::delete('/profesor-baja-alumno/{inscripcion_id}', [App\Http\Controllers\ProfesorController::class, 'deleteInscripcion'])->name('profesor.deleteInscripcion');

    // admin
    Route::get('/dashboard', [adminController::class, 'indexAdmin'])->name('index.admin');
    Route::get('/materia', [adminController::class, 'indexMateria'])->name('index.materia');
    Route::post('/materia', [adminController::class, 'saveMateria'])->name('save.materia');
    Route::delete('/eliminarmateria/{id}', [adminController::class, 'deleteMateria'])->name('delete.materia');
    Route::get('/modificarmateria/{id}', [adminController::class, 'editMateria'])->name('modificar.materia');
    Route::post('/modificarmateria/{id}', [adminController::class, 'updateMateria'])->name('update.materia');

    // horarios
    Route::get('/horario', [adminController::class, 'indexHorario'])->name('index.horario');
    Route::get('/regHorario/{materia_id}', [adminController::class, 'createHorario'])->name('create.horario');
    Route::post('/regHorario', [adminController::class, 'saveHorario'])->name('save.horario');
    Route::get('/modificarhorario/{id}', [adminController::class, 'editHorario'])->name('modificar.horario');
    Route::post('/modificarhorario/{id}', [adminController::class, 'updateHorario'])->name('update.horario');
    Route::delete('/eliminarhorario/{id}', [adminController::class, 'deleteHorario'])->name('delete.horario');

    // grupos
    Route::get('/grupos', [adminController::class, 'indexGrupos'])->name('index.grupos');
    Route::get('/regGrupo/{horario_id}', [adminController::class, 'createGrupo'])->name('create.grupo');
    Route::post('/regGrupo', [adminController::class, 'saveGrupo'])->name('save.grupo');
    Route::get('/modificargrupo/{id}', [adminController::class, 'editGrupo'])->name('modificar.grupo');
    Route::post('/modificargrupo/{id}', [adminController::class, 'updateGrupo'])->name('update.grupo');
    Route::delete('/eliminargrupo/{id}', [adminController::class, 'deleteGrupo'])->name('delete.grupo');

    // inscripciones
    Route::get('/inscripciones/{grupo_id}', [adminController::class, 'viewInscripciones'])->name('view.inscripciones');
    Route::delete('/eliminarinscripcion/{id}', [adminController::class, 'deleteInscripcion'])->name('delete.inscripcion');
    
    // calificaciones
    Route::get('/calificar/{inscripcion_id}', [adminController::class, 'createCalificacion'])->name('create.calificacion');
    Route::post('/calificar', [adminController::class, 'saveCalificacion'])->name('save.calificacion');
});

