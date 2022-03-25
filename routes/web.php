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
Route::get('/roles/edit', [RoleController::class, 'edit'])->middleware(['auth', 'verified'])->name('roles.edit');
Route::post('/roles/update', [RoleController::class, 'update'])->middleware(['auth', 'verified'])->name('roles.update');
Route::delete('/roles/destroy/{role}', [RoleController::class, 'destroy'])->middleware(['auth', 'verified'])->name('roles.destroy');

/* Menus */
Route::get('/menus', [MenuController::class, 'index'])->middleware(['auth', 'verified'])->name('menus');
Route::get('/menus/add-menu', [MenuController::class, 'addMenu'])->middleware(['auth', 'verified'])->name('menus.add_menu');
Route::post('/menus/add-menu/store', [MenuController::class, 'storeMenu'])->middleware(['auth', 'verified'])->name('menus.store_menu');
Route::get('/menus/add-sub-menu', [MenuController::class, 'addSubMenu'])->middleware(['auth', 'verified'])->name('menus.add_sub_menu');
Route::post('/menus/add-sub-menu/store', [MenuController::class, 'storeSubMenu'])->middleware(['auth', 'verified'])->name('menus.store_sub_menu');
Route::get('/menus/edit-menu', [MenuController::class, 'editMenu'])->middleware(['auth', 'verified'])->name('menus.edit_menu');
Route::post('/menus/edit-menu/update', [MenuController::class, 'updateMenu'])->middleware(['auth', 'verified'])->name('menus.update_menu');
Route::get('/menus/edit-sub-menu', [MenuController::class, 'editSubMenu'])->middleware(['auth', 'verified'])->name('menus.edit_sub_menu');
Route::post('/menus/edit-sub-menu/update', [MenuController::class, 'updateSubMenu'])->middleware(['auth', 'verified'])->name('menus.update_sub_menu');
Route::delete('/menus/destroy-menu/{id}', [MenuController::class, 'destroyMenu'])->middleware(['auth', 'verified'])->name('menus.destroy_menu');
Route::delete('/menus/destroy-sub-menu/{id}', [MenuController::class, 'destroySubMenu'])->middleware(['auth', 'verified'])->name('menus.destroy_sub_menu');

/* Permissions */
Route::get('/permissions', [RoleController::class, 'getAllRoles'])->middleware(['auth', 'verified'])->name('permissions');

require __DIR__.'/auth.php';
