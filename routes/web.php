<?php

use App\Http\Controllers\MenuController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/* Users */
Route::get('/users', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('users');
Route::delete('/delete-users', [UserController::class, 'destroy'])->middleware(['auth', 'verified'])->name('users.destroy');

/* Roles */
Route::get('/roles', [RoleController::class, 'index'])->middleware(['auth', 'verified'])->name('roles');
Route::get('/roles/create', [RoleController::class, 'create'])->middleware(['auth', 'verified'])->name('roles.create');
Route::post('/roles/store', [RoleController::class, 'store'])->middleware(['auth', 'verified'])->name('roles.store');
Route::delete('/roles/destroy/{role}', [RoleController::class, 'destroy'])->middleware(['auth', 'verified'])->name('roles.destroy');

Route::get('/menus', [MenuController::class, 'index'])->middleware(['auth', 'verified'])->name('menus');
Route::get('/menus/add', [MenuController::class, 'addMenu'])->middleware(['auth', 'verified'])->name('menus.add_menu');
Route::get('/menus/add-sub-menu', [MenuController::class, 'addSubMenu'])->middleware(['auth', 'verified'])->name('menus.add_sub_menu');

/* Permissions */
Route::get('/permissions', [RoleController::class, 'getAllRoles'])->middleware(['auth', 'verified'])->name('permissions');

require __DIR__.'/auth.php';
