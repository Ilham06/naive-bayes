<?php

use App\Http\Controllers\ConditionController;
use App\Http\Controllers\ConditionDataController;
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

Route::get('condition', [ConditionController::class, 'index'])->name('condition.index');
Route::post('condition', [ConditionController::class, 'store'])->name('condition.store');
Route::delete('condition/{id}', [ConditionController::class, 'destroy'])->name('condition.destroy');

Route::get('data', [ConditionDataController::class, 'index'])->name('condition-data.index');
Route::post('data', [ConditionDataController::class, 'store'])->name('condition-data.store');

Route::post('calculate', [ConditionDataController::class, 'calculate'])->name('condition-data.calculate');
Route::get('create', [ConditionDataController::class, 'createClasification'])->name('condition-data.create');
