<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/login', [UserController::class, 'login']);
Route::post('/loginCheck', [UserController::class, 'loginCheck']);
Route::get('/register', [UserController::class, 'index']);
Route::get('/dashboard', [UserController::class, 'dashboard']);
Route::get('/logout', [UserController::class, 'logout']);
Route::get('/users', [UserController::class, 'users'])->name('users');
Route::get('/projects', [UserController::class, 'projects'])->name('projects');
Route::get('/tasks', [UserController::class, 'tasks'])->name('tasks');
Route::get('/changePass/{id}', [UserController::class, 'changePass'])->name('changePass');
Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile');
Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
Route::get('/deleteProject/{id}', [UserController::class, 'deleteProject'])->name('deleteProject');
Route::get('/deleteTask/{id}', [UserController::class, 'deleteTask'])->name('deleteTask');
Route::get('/statusUpdate/{id}/{status}', [UserController::class, 'statusUpdate']);
Route::get('/projectStatusUpdate/{id}/{status}', [UserController::class, 'projectStatusUpdate']);
Route::get('/taskStatusUpdate/{id}/{status}', [UserController::class, 'taskStatusUpdate']);

Route::post('/registerData', [UserController::class, 'register']);
Route::post('/updateUserDate', [UserController::class, 'updateUserDate']);
Route::post('/changePasword', [UserController::class, 'changePasword']);
Route::post('/addUser', [UserController::class, 'store']);
Route::post('/addProject', [UserController::class, 'storeProject']);
Route::post('/addTask', [UserController::class, 'storeTask']);

