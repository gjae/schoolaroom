<?php

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(('auth:sanctum'))->group(function(){

    Route::resource('periods', App\Http\Controllers\PeriodController::class)
        ->names([
            'index' => 'periods.index',
            'show' => 'periods.show',
            'create' => 'periods.create',
            'edit' => 'periods.edit',
            'store' => 'periods.store',
            'destroy' => 'periods.destroy'
        ]);

    Route::resource('periods.groups', \App\Http\Controllers\GroupController::class);

});