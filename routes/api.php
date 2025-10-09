<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormBacController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/submit/form/quick',[FormController::class, 'submitFormQuick'])->name('form.quick.submit');


Route::post('/submit/form/master',[FormController::class, 'submitFormMaster'])->name('form.master.submit');

Route::post('/submit/form/licencexcellence',[FormController::class, 'submitFormLicenceExcellence'])->name('form.licencexcellence.submit');

Route::post('/submit/form/bac/acceeouvert',[FormBacController::class, 'submitFormBacAcceeOuvert'])->name('form.licencexcellence.submit');
