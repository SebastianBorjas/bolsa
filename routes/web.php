<?php

use App\Http\Controllers\BolsaController;
use App\Http\Controllers\RegistroController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('bolsa.registro');
});

Route::get('/bolsa', [RegistroController::class, 'create'])->name('bolsa.registro');
Route::post('/bolsa', [RegistroController::class, 'store'])->name('bolsa.registro.store');
Route::get('/bolsa/registro-exitoso', [RegistroController::class, 'success'])->name('bolsa.registro.success');
Route::get('/bolsa/admin', [BolsaController::class, 'index'])->name('bolsa.index');
Route::get('/bolsa/admin/empleados', [BolsaController::class, 'empleados'])->name('bolsa.empleados');
Route::get('/bolsa/admin/curriculum/{empleado}/preview', [BolsaController::class, 'previewCurriculum'])->name('bolsa.curriculum.preview');
Route::get('/bolsa/admin/curriculum/{empleado}/download', [BolsaController::class, 'downloadCurriculum'])->name('bolsa.curriculum.download');
Route::put('/bolsa/admin/empleados/{empleado}', [BolsaController::class, 'updateEmpleado'])->name('bolsa.empleados.update');
Route::delete('/bolsa/admin/empleados/{empleado}', [BolsaController::class, 'destroyEmpleado'])->name('bolsa.empleados.destroy');
Route::post('/bolsa/admin/empleados/{empleado}/enviar', [BolsaController::class, 'sendCv'])->name('bolsa.empleados.send');
Route::post('/bolsa/admin/empleados/enviar-multiple', [BolsaController::class, 'sendMultiple'])->name('bolsa.empleados.sendMultiple');
Route::get('/bolsa/admin/areas', [BolsaController::class, 'areas'])->name('bolsa.areas');
Route::post('/bolsa/admin/areas', [BolsaController::class, 'storeArea'])->name('bolsa.areas.store');
Route::put('/bolsa/admin/areas/{area}', [BolsaController::class, 'updateArea'])->name('bolsa.areas.update');
Route::delete('/bolsa/admin/areas/{area}', [BolsaController::class, 'destroyArea'])->name('bolsa.areas.destroy');
Route::post('/bolsa/admin/areas/subareas', [BolsaController::class, 'storeSubarea'])->name('bolsa.subareas.store');
Route::put('/bolsa/admin/areas/subareas/{subarea}', [BolsaController::class, 'updateSubarea'])->name('bolsa.subareas.update');
Route::delete('/bolsa/admin/areas/subareas/{subarea}', [BolsaController::class, 'destroySubarea'])->name('bolsa.subareas.destroy');
Route::get('/bolsa/admin/sugerencias', [BolsaController::class, 'sugerencias'])->name('bolsa.sugerencias');
Route::put('/bolsa/admin/empleados/{empleado}/reasignar', [BolsaController::class, 'reassignEmpleado'])->name('bolsa.empleados.reassign');
Route::post('/bolsa/admin/login', [BolsaController::class, 'login'])->name('bolsa.login');
Route::post('/bolsa/admin/logout', [BolsaController::class, 'logout'])->name('bolsa.logout');
