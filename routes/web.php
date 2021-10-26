<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeController;

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
    return view('index');
});

Route::post('/employes',[EmployeController::class,'create']);
Route::get('/employes',[EmployeController::class,'index']);
Route::put('/employes',[EmployeController::class,'update']);

