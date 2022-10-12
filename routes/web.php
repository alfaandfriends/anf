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
use App\Http\Controllers\DiagnosticTestController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\StudentController;

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
    /* User Impersonation */
    Route::get('/impersonate/{user}', [AuthenticatedSessionController::class, 'impersonate'])->name('impersonate');
    Route::get('/leave-impersonate', [AuthenticatedSessionController::class, 'leaveImpersonate'])->name('leave-impersonate');

    /* Dashboard */
        /* User */
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* Profile */
    Route::get('/profile', [ProfileController::class, 'create'])->name('profile');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
    Route::post('/profile/security/store', [ProfileController::class, 'storeSecurity'])->name('profile.security.store');

    /* Users */
    Route::prefix('control-panel')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/assign-centre-roles', [UserController::class, 'assignCentresRoles'])->name('users.assign_centres_roles');
        Route::post('/users/assign-centre-roles/store', [UserController::class, 'assignCentresRolesStore'])->name('users.assign_centres_roles.store');
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
        Route::post('/menus/swap-menu/up', [MenuController::class, 'swapMenuUp'])->name('menus.swap_menu_up');
        Route::post('/menus/swap-menu/down', [MenuController::class, 'swapMenuDown'])->name('menus.swap_menu_down');
        Route::post('/menus/swap-sub-menu/up', [MenuController::class, 'swapSubMenuUp'])->name('menus.swap_sub_menu_up');
        Route::post('/menus/swap-sub-menu/down', [MenuController::class, 'swapSubMenuDown'])->name('menus.swap_sub_menu_down');

        /* Permissions */
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::post('/permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/destroy/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

        /* Countries */
        Route::get('/control-panel/general/countries', [SettingController::class, 'countryList'])->name('settings.countries');
        Route::get('/control-panel/general/countries/create', [SettingController::class, 'addCountry'])->name('settings.countries.create');
        Route::post('/control-panel/general/countries/store', [SettingController::class, 'storeCountry'])->name('settings.countries.store');
        Route::get('/control-panel/general/countries/edit', [SettingController::class, 'editCountry'])->name('settings.countries.edit');
        Route::post('/control-panel/general/countries/update', [SettingController::class, 'updateCountry'])->name('settings.countries.update');
        Route::delete('/control-panel/general/countries/destroy/{id}', [SettingController::class, 'destroyCountry'])->name('settings.countries.destroy');
    });

    /* Centres */
    Route::prefix('centre-management')->group(function () {
        Route::get('/centres', [CentreController::class, 'index'])->name('centres');
        Route::get('/centres/create', [CentreController::class, 'create'])->name('centres.create');
        Route::post('/centres/store', [CentreController::class, 'store'])->name('centres.store');
        Route::get('/centres/edit', [CentreController::class, 'edit'])->name('centres.edit');
        Route::post('/centres/update', [CentreController::class, 'update'])->name('centres.update');  
        Route::delete('/centres/destroy/{id}', [CentreController::class, 'destroy'])->name('centres.destroy');
        Route::delete('/centres/image/destroy/{id}', [CentreController::class, 'destroyImage'])->name('centres.destroy_image');
        Route::get('/centres/images', [CentreController::class, 'getCentreImages'])->name('centres.get_images');

        /* Classes */
        Route::get('/classes', [ClassController::class, 'index'])->name('classes');
        Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');
        Route::post('/classes/store', [ClassController::class, 'store'])->name('classes.store');
        Route::get('/classes/edit', [ClassController::class, 'edit'])->name('classes.edit');
        Route::post('/classes/update', [ClassController::class, 'update'])->name('classes.update');  
        Route::delete('/classes/destroy/{id}', [ClassController::class, 'destroy'])->name('classes.destroy');

        /* Students */
        Route::get('/students', [StudentController::class, 'index'])->name('students');
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::post('/students/update', [StudentController::class, 'update'])->name('students.update');  
        Route::delete('/students/destroy/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

        /* Fees */
        Route::get('/fees', [FeeController::class, 'index'])->name('fees');
        Route::get('/fees/create', [FeeController::class, 'create'])->name('fees.create');
        Route::post('/fees/store', [FeeController::class, 'store'])->name('fees.store');
        Route::get('/fees/edit', [FeeController::class, 'edit'])->name('fees.edit');
        Route::post('/fees/update', [FeeController::class, 'update'])->name('fees.update');  
        Route::delete('/fees/destroy/{id}', [FeeController::class, 'destroy'])->name('fees.destroy');

        /* Settings */    
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
            /* Fee Types */
            Route::get('/settings/fee_type_list', [SettingController::class, 'feeTypeList'])->name('settings.fee_type_list');
            Route::get('/settings/fee_type_list/create', [SettingController::class, 'addFeeType'])->name('settings.fee_type_list.create');
            Route::post('/settings/fee_type_list/store', [SettingController::class, 'storeFeeType'])->name('settings.fee_type_list.store');
            Route::get('/settings/fee_type_list/edit', [SettingController::class, 'editFeeType'])->name('settings.fee_type_list.edit');
            Route::post('/settings/fee_type_list/update', [SettingController::class, 'updateFeeType'])->name('settings.fee_type_list.update');
            Route::delete('/settings/fee_type_list/destroy/{id}', [SettingController::class, 'destroyFeeType'])->name('settings.fee_type_list.destroy');

            /* Fee Periods */
            Route::get('/settings/fee_period_list', [SettingController::class, 'feePeriodList'])->name('settings.fee_period_list');
            Route::get('/settings/fee_period_list/create', [SettingController::class, 'addfeePeriod'])->name('settings.fee_period_list.create');
            Route::post('/settings/fee_period_list/store', [SettingController::class, 'storefeePeriod'])->name('settings.fee_period_list.store');
            Route::get('/settings/fee_period_list/edit', [SettingController::class, 'editfeePeriod'])->name('settings.fee_period_list.edit');
            Route::post('/settings/fee_period_list/update', [SettingController::class, 'updatefeePeriod'])->name('settings.fee_period_list.update');
            Route::delete('/settings/fee_period_list/destroy/{id}', [SettingController::class, 'destroyfeePeriod'])->name('settings.fee_period_list.destroy');

            /* Programmes*/
            Route::get('/settings/programmes', [SettingController::class, 'programmeList'])->name('settings.programmes');
            Route::get('/settings/programmes/create', [SettingController::class, 'addProgramme'])->name('settings.programmes.create');
            Route::post('/settings/programmes/store', [SettingController::class, 'storeProgramme'])->name('settings.programmes.store');
            Route::get('/settings/programmes/edit', [SettingController::class, 'editProgramme'])->name('settings.programmes.edit');
            Route::post('/settings/programmes/update', [SettingController::class, 'updateProgramme'])->name('settings.programmes.update');  
            Route::delete('/settings/programmes/destroy/{id}', [SettingController::class, 'destroyProgramme'])->name('settings.programmes.destroy');
    });



    /* Run Diagnostic Test */
    Route::get('/diagnostic-test', [DiagnosticTestController::class, 'dtStartList'])->name('diagnostic_test');
    Route::get('/diagnostic-test/start', [DiagnosticTestController::class, 'dtStart'])->name('diagnostic_test.run');

    /* Diagnostic Test Setup*/
    Route::prefix('control-panel')->group(function () {
        /* Diagnostic Test List */
        Route::get('/general/diagnostic-test', [SettingController::class, 'dtList'])->name('settings.diagnostic_test');
        Route::get('/general/diagnostic-test/create', [SettingController::class, 'dtCreate'])->name('settings.diagnostic_test.create');
        Route::post('/general/diagnostic-test/store', [SettingController::class, 'dtStore'])->name('settings.diagnostic_test.store');
        Route::get('/general/diagnostic-test/edit', [SettingController::class, 'dtEdit'])->name('settings.diagnostic_test.edit');
        Route::post('/general/diagnostic-test/update', [SettingController::class, 'dtUpdate'])->name('settings.diagnostic_test.update');
        Route::delete('/general/diagnostic-test/destroy/{id}', [SettingController::class, 'dtDestroy'])->name('settings.diagnostic_test.destroy');

        /* Diagnostic Test Detail List */
        Route::get('/general/diagnostic-test/details', [SettingController::class, 'dtDetailsList'])->name('settings.diagnostic_test.details');
        Route::get('/general/diagnostic-test/details/create', [SettingController::class, 'dtDetailsCreate'])->name('settings.diagnostic_test.details.create');
        Route::post('/general/diagnostic-test/details/store', [SettingController::class, 'dtDetailsStore'])->name('settings.diagnostic_test.details.store');
        Route::get('/general/diagnostic-test/details/edit', [SettingController::class, 'dtDetailsEdit'])->name('settings.diagnostic_test.details.edit');
        Route::post('/general/diagnostic-test/details/update', [SettingController::class, 'dtDetailsUpdate'])->name('settings.diagnostic_test.details.update');
        Route::delete('/general/diagnostic-test/details/destroy/{id}', [SettingController::class, 'dtDetailsDestroy'])->name('settings.diagnostic_test.details.destroy');
        Route::post('/general/diagnostic-test/details/sort', [SettingController::class, 'dtDetailsSort'])->name('settings.diagnostic_test.details.sort');

        /* Diagnostic Test Detail Conditions */
        Route::get('/general/diagnostic-test/conditions/create', [SettingController::class, 'dtConditionsCreate'])->name('settings.diagnostic_test.conditions.create');
        Route::post('/general/diagnostic-test/conditions/store', [SettingController::class, 'dtConditionsStore'])->name('settings.diagnostic_test.conditions.store');
        Route::get('/general/diagnostic-test/conditions/edit', [SettingController::class, 'dtConditionsEdit'])->name('settings.diagnostic_test.conditions.edit');
        Route::post('/general/diagnostic-test/conditions/update', [SettingController::class, 'dtConditionsUpdate'])->name('settings.diagnostic_test.conditions.update');
        Route::delete('/general/diagnostic-test/conditions/destroy/{id}', [SettingController::class, 'dtConditionsDestroy'])->name('settings.diagnostic_test.conditions.destroy');

        /* Diagnostic Test Detail Categories */
        Route::get('/general/diagnostic-test/categories/create', [SettingController::class, 'dtCategoriesCreate'])->name('settings.diagnostic_test.categories.create');
        Route::post('/general/diagnostic-test/categories/store', [SettingController::class, 'dtCategoriesStore'])->name('settings.diagnostic_test.categories.store');
        Route::get('/general/diagnostic-test/categories/edit', [SettingController::class, 'dtCategoriesEdit'])->name('settings.diagnostic_test.categories.edit');
        Route::post('/general/diagnostic-test/categories/update', [SettingController::class, 'dtCategoriesUpdate'])->name('settings.diagnostic_test.categories.update');
        Route::delete('/general/diagnostic-test/categories/destroy/{id}', [SettingController::class, 'dtCategoriesDestroy'])->name('settings.diagnostic_test.categories.destroy');
    });
    
    /* Shop */
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/shop/cart', [ShopController::class, 'shopCart'])->name('shop.cart');
    Route::get('/shop/checkout', [ShopController::class, 'shopCheckout'])->name('shop.checkout');
    Route::post('/shop/payment', [ShopController::class, 'shopPayment'])->name('shop.payment');
    Route::get('/shop/payment/status', [ShopController::class, 'shopPaymentStatus'])->name('shop.payment.status');
});
require __DIR__.'/auth.php';
