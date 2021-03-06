<?php

use App\Http\Controllers\CargoController;
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

/* Route::get('/', function () {
    return view('welcome');
});
 */

Route::resource('/', CargoController::class);
Route::get('/wharfage', [CargoController::class, 'processWharfageBill']);
Route::get('/storage', [CargoController::class, 'processStorageBill']);
Route::get('/destuffing', [CargoController::class, 'processDestuffingBill']);
Route::get('/lifting', [CargoController::class, 'processLiftingBill']);
Route::get('/summary', [CargoController::class, 'summary']);
Route::post('/create-bill', [CargoController::class, 'createBill']);
