<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CentreController;
use Illuminate\Http\Request;

/* Authorized Only */
Route::middleware(['auth', 'check_role'])->group(function(){

    /* Default Landing Page */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/', function () {
    //     return Inertia::render('Welcome', [
    //         'canLogin' => Route::has('login'),
    //         'canRegister' => Route::has('register'),
    //         'laravelVersion' => Application::VERSION,
    //         'phpVersion' => PHP_VERSION,
    //     ]);
    // });

    /* Dashboard */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* Profile */
    Route::get('/profile', [ProfileController::class, 'create'])->name('profile');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');

    /* Users */
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/assign-roles', [UserController::class, 'assignRoles'])->name('users.assign_roles');
    Route::post('/users/assign-roles/store', [UserController::class, 'assignRolesStore'])->name('users.assign_roles.store');
    Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/completed-tour', [UserController::class, 'completedTour'])->name('users.completed_tour');

    /* Roles */
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/update', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/destroy/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles/assign-permissions', [RoleController::class, 'assignPermissions'])->name('roles.assign_pemissions');
    Route::post('/roles/assign-permissions/store', [RoleController::class, 'assignPermissionsStore'])->name('roles.assign_permissions.store');

    /* Menus */
    Route::get('/menus', [MenuController::class, 'index'])->name('menus');
    Route::get('/menus/add-menu', [MenuController::class, 'addMenu'])->name('menus.add_menu');
    Route::post('/menus/add-menu/store', [MenuController::class, 'storeMenu'])->name('menus.store_menu');
    Route::get('/menus/add-sub-menu', [MenuController::class, 'addSubMenu'])->name('menus.add_sub_menu');
    Route::post('/menus/add-sub-menu/store', [MenuController::class, 'storeSubMenu'])->name('menus.store_sub_menu');
    Route::get('/menus/edit-menu', [MenuController::class, 'editMenu'])->name('menus.edit_menu');
    Route::post('/menus/edit-menu/update', [MenuController::class, 'updateMenu'])->name('menus.update_menu');
    Route::get('/menus/edit-sub-menu', [MenuController::class, 'editSubMenu'])->name('menus.edit_sub_menu');
    Route::post('/menus/edit-sub-menu/update', [MenuController::class, 'updateSubMenu'])->name('menus.update_sub_menu');
    Route::delete('/menus/destroy-menu/{id}', [MenuController::class, 'destroyMenu'])->name('menus.destroy_menu');
    Route::delete('/menus/destroy-sub-menu/{id}', [MenuController::class, 'destroySubMenu'])->name('menus.destroy_sub_menu');

    /* Permissions */
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/destroy/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    /* Centres */
    Route::get('/centres', [CentreController::class, 'index'])->name('centres');
    Route::get('/centres/create', [CentreController::class, 'create'])->name('centres.create');
    Route::post('/centres/store', [CentreController::class, 'store'])->name('centres.store');  
    
});
require __DIR__.'/auth.php';
