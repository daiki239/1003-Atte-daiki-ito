<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
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

/*
index
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [StampController::class, 'index']);
Route::post('/stamp', [StampController::class, 'stamp']);
Route::post('/stamped',  [StampController::class, 'stamped']);
Route::post('/rest', [StampController::class, 'rest']);
Route::post('/rested',  [StampController::class, 'rested']);
Route::get('/home', [StampController::class, 'index']);

/*
attendance
*/
Route::get('/attendance',  [StampController::class, 'attendance']);



Route::get('/logout', [StampController::class, 'logout']);




Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
