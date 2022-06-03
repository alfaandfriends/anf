<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingController;

/* Authorized Only */
Route::middleware(['auth', 'check_role'])->group(function(){

    /* Default Landing Page */
    Route::get('/', [DashboardController::class, 'index']);
    // Route::get('/', function () {
    //     return Inertia::render('Welcome', [
    //         'canLogin' => Route::has('login'),
    //         'canRegister' => Route::has('register'),
    //         'laravelVersion' => Application::VERSION,
    //         'phpVersion' => PHP_VERSION,
    //     ]);
    // });

    /* Dashboard */
        /* Admin */
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /* User */
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* Profile */
    Route::get('/profile', [ProfileController::class, 'create'])->name('profile');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');

    /* Users */
    Route::get('/control_panel/users', [UserController::class, 'index'])->name('users');
    Route::get('/control_panel/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/control_panel/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/control_panel/users/assign-roles', [UserController::class, 'assignRoles'])->name('users.assign_roles');
    Route::post('/control_panel/users/assign-roles/store', [UserController::class, 'assignRolesStore'])->name('users.assign_roles.store');
    Route::delete('/control_panel/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/control_panel/users/completed-tour', [UserController::class, 'completedTour'])->name('users.completed_tour');

    /* Roles */
    Route::get('/control_panel/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/control_panel/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/control_panel/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/control_panel/roles/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/control_panel/roles/update', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/control_panel/roles/destroy/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/control_panel/roles/assign-permissions', [RoleController::class, 'assignPermissions'])->name('roles.assign_pemissions');
    Route::post('/control_panel/roles/assign-permissions/store', [RoleController::class, 'assignPermissionsStore'])->name('roles.assign_permissions.store');

    /* Menus */
    Route::get('/control_panel/menus', [MenuController::class, 'index'])->name('menus');
    Route::get('/control_panel/menus/add-menu', [MenuController::class, 'addMenu'])->name('menus.add_menu');
    Route::post('/control_panel/menus/add-menu/store', [MenuController::class, 'storeMenu'])->name('menus.store_menu');
    Route::get('/control_panel/menus/add-sub-menu', [MenuController::class, 'addSubMenu'])->name('menus.add_sub_menu');
    Route::post('/control_panel/menus/add-sub-menu/store', [MenuController::class, 'storeSubMenu'])->name('menus.store_sub_menu');
    Route::get('/control_panel/menus/edit-menu', [MenuController::class, 'editMenu'])->name('menus.edit_menu');
    Route::post('/control_panel/menus/edit-menu/update', [MenuController::class, 'updateMenu'])->name('menus.update_menu');
    Route::get('/control_panel/menus/edit-sub-menu', [MenuController::class, 'editSubMenu'])->name('menus.edit_sub_menu');
    Route::post('/control_panel/menus/edit-sub-menu/update', [MenuController::class, 'updateSubMenu'])->name('menus.update_sub_menu');
    Route::delete('/control_panel/menus/destroy-menu/{id}', [MenuController::class, 'destroyMenu'])->name('menus.destroy_menu');
    Route::delete('/control_panel/menus/destroy-sub-menu/{id}', [MenuController::class, 'destroySubMenu'])->name('menus.destroy_sub_menu');
    Route::post('/control_panel/menus/swap-menu/up', [MenuController::class, 'swapMenuUp'])->name('menus.swap_menu_up');
    Route::post('/control_panel/menus/swap-menu/down', [MenuController::class, 'swapMenuDown'])->name('menus.swap_menu_down');
    Route::post('/control_panel/menus/swap-sub-menu/up', [MenuController::class, 'swapSubMenuUp'])->name('menus.swap_sub_menu_up');
    Route::post('/control_panel/menus/swap-sub-menu/down', [MenuController::class, 'swapSubMenuDown'])->name('menus.swap_sub_menu_down');

    /* Permissions */
    Route::get('/control_panel/permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::get('/control_panel/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/control_panel/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/control_panel/permissions/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/control_panel/permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/control_panel/permissions/destroy/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    /* Centres */
    Route::get('/centre_management/centres', [CentreController::class, 'index'])->name('centres');
    Route::get('/centre_management/centres/create', [CentreController::class, 'create'])->name('centres.create');
    Route::post('/centre_management/centres/store', [CentreController::class, 'store'])->name('centres.store');
    Route::get('/centre_management/centres/edit', [CentreController::class, 'edit'])->name('centres.edit');
    Route::post('/centre_management/centres/update', [CentreController::class, 'update'])->name('centres.update');  
    Route::delete('/centre_management/centres/destroy/{id}', [CentreController::class, 'destroy'])->name('centres.destroy');
    Route::delete('/centre_management/centres/image/destroy/{id}', [CentreController::class, 'destroyImage'])->name('centres.destroy_image');
    Route::get('/centre_management/centres/images', [CentreController::class, 'getCentreImages'])->name('centres.get_images');

    /* Classes */
    Route::get('/centre_management/classes', [ClassController::class, 'index'])->name('classes');
    Route::get('/centre_management/classes/create', [ClassController::class, 'create'])->name('classes.create');
    Route::post('/centre_management/classes/store', [ClassController::class, 'store'])->name('classes.store');
    Route::get('/centre_management/classes/edit', [ClassController::class, 'edit'])->name('classes.edit');
    Route::post('/centre_management/classes/update', [ClassController::class, 'update'])->name('classes.update');  
    Route::delete('/centre_management/classes/destroy/{id}', [ClassController::class, 'destroy'])->name('classes.destroy');

    /* Session */
    Route::get('/centre_management/sessions', [SessionController::class, 'index'])->name('sessions');
    Route::get('/centre_management/sessions/create', [SessionController::class, 'create'])->name('sessions.create');
    Route::post('/centre_management/sessions/store', [SessionController::class, 'store'])->name('sessions.store');
    Route::get('/centre_management/sessions/edit', [SessionController::class, 'edit'])->name('sessions.edit');
    Route::post('/centre_management/sessions/update', [SessionController::class, 'update'])->name('sessions.update');  
    Route::delete('/centre_management/sessions/destroy/{id}', [SessionController::class, 'destroy'])->name('sessions.destroy');

    /* Fees */
    Route::get('/centre_management/fees', [FeeController::class, 'index'])->name('fees');
    Route::get('/centre_management/fees/create', [FeeController::class, 'create'])->name('fees.create');
    Route::post('/centre_management/fees/store', [FeeController::class, 'store'])->name('fees.store');
    Route::get('/centre_management/fees/edit', [FeeController::class, 'edit'])->name('fees.edit');
    Route::post('/centre_management/fees/update', [FeeController::class, 'update'])->name('fees.update');  
    Route::delete('/centre_management/fees/destroy/{id}', [FeeController::class, 'destroy'])->name('fees.destroy');

    /* Settings */    
    Route::get('/centre_management/settings', [SettingController::class, 'index'])->name('settings');
        /* Fee Types */
        Route::get('/centre_management/settings/fee_type_list', [SettingController::class, 'feeTypeList'])->name('settings.fee_type_list');
        Route::get('/centre_management/settings/fee_type_list/create', [SettingController::class, 'addFeeType'])->name('settings.fee_type_list.create');
        Route::post('/centre_management/settings/fee_type_list/store', [SettingController::class, 'storeFeeType'])->name('settings.fee_type_list.store');
        Route::get('/centre_management/settings/fee_type_list/edit', [SettingController::class, 'editFeeType'])->name('settings.fee_type_list.edit');
        Route::post('/centre_management/settings/fee_type_list/update', [SettingController::class, 'updateFeeType'])->name('settings.fee_type_list.update');
        Route::delete('/centre_management/settings/fee_type_list/destroy/{id}', [SettingController::class, 'destroyFeeType'])->name('settings.fee_type_list.destroy');
        /* Fee Periods */
        Route::get('/centre_management/settings/fee_period_list', [SettingController::class, 'feePeriodList'])->name('settings.fee_period_list');
        Route::get('/centre_management/settings/fee_period_list/create', [SettingController::class, 'addfeePeriod'])->name('settings.fee_period_list.create');
        Route::post('/centre_management/settings/fee_period_list/store', [SettingController::class, 'storefeePeriod'])->name('settings.fee_period_list.store');
        Route::get('/centre_management/settings/fee_period_list/edit', [SettingController::class, 'editfeePeriod'])->name('settings.fee_period_list.edit');
        Route::post('/centre_management/settings/fee_period_list/update', [SettingController::class, 'updatefeePeriod'])->name('settings.fee_period_list.update');
        Route::delete('/centre_management/settings/fee_period_list/destroy/{id}', [SettingController::class, 'destroyfeePeriod'])->name('settings.fee_period_list.destroy');

        /* Countries */
        Route::get('/control_panel/general/countries', [SettingController::class, 'feeTypeList'])->name('settings.countries');
        Route::get('/control_panel/general/countries/create', [SettingController::class, 'addFeeType'])->name('settings.countries.create');
        Route::post('/control_panel/general/countries/store', [SettingController::class, 'storeFeeType'])->name('settings.countries.store');
        Route::get('/control_panel/general/countries/edit', [SettingController::class, 'editFeeType'])->name('settings.countries.edit');
        Route::post('/control_panel/general/countries/update', [SettingController::class, 'updateFeeType'])->name('settings.countries.update');
        Route::delete('/control_panel/general/countries/destroy/{id}', [SettingController::class, 'destroyFeeType'])->name('settings.countries.destroy');
    /* Settings */    

    
});
require __DIR__.'/auth.php';
