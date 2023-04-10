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
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExternalUserManagementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProgrammeController;

/* Authorized Only */
Route::middleware(['auth'])->group(function(){
    /* Default Landing Page */
    Route::get('/', function () {
        return redirect('/dashboard');
    });
    
    /* User Impersonation */
    Route::get('/impersonate/{user}', [AuthenticatedSessionController::class, 'impersonate'])->name('impersonate');
    Route::get('/leave-impersonate', [AuthenticatedSessionController::class, 'leaveImpersonate'])->name('leave-impersonate');;

    /* Dashboard */
    /* User */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:dashboard_access');

    /* Profile */
    Route::get('/profile', [ProfileController::class, 'create'])->name('profile')->middleware('permission:profile_access');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store')->middleware('permission:profile_access');
    Route::post('/profile/security/store', [ProfileController::class, 'storeSecurity'])->name('profile.security.store')->middleware('permission:profile_access');

    /* Children */
    Route::get('/children', [ChildrenController::class, 'create'])->name('children')->middleware('permission:children_view_access');
    Route::post('/children/store', [ChildrenController::class, 'store'])->name('children.store')->middleware('permission:children_create_access');
    Route::get('/children/edit', [ChildrenController::class, 'edit'])->name('children.edit')->middleware('permission:children_edit_access');
    Route::post('/children/update', [ChildrenController::class, 'update'])->name('children.update')->middleware('permission:children_edit_access');

    /* Control Panel */
    Route::prefix('control-panel')->group(function () {
        /* Users */
        Route::get('/users', [UserController::class, 'index'])->name('users')->middleware('permission:cp_users_view_access');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:cp_users_create_access');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store')->middleware('permission:cp_users_create_access');
        Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:cp_users_edit_access');
        Route::post('/users/manage-roles/store', [UserController::class, 'manageRolesStore'])->name('users.manage_roles.store')->middleware('permission:cp_users_edit_access');
        Route::post('/users/reset-user-password', [UserController::class, 'resetUserPassword'])->name('users.reset_user_password')->middleware('permission:cp_users_edit_access');
        Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:cp_users_delete_access');
        Route::post('/users/completed-tour', [UserController::class, 'completedTour'])->name('users.completed_tour');
        Route::get('/get-user-info/{id}', [UserController::class, 'getUserInfo'])->name('users.get_info');

        /* Roles */
        Route::get('/roles', [RoleController::class, 'index'])->name('roles')->middleware('permission:cp_roles_view_access');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:cp_roles_create_access');
        Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:cp_roles_create_access');
        Route::get('/roles/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:cp_roles_edit_access');
        Route::post('/roles/update', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:cp_roles_edit_access');
        Route::delete('/roles/destroy/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:cp_roles_delete_access');
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
        Route::get('/general/countries', [SettingController::class, 'countryList'])->name('settings.countries');
        Route::get('/general/countries/create', [SettingController::class, 'addCountry'])->name('settings.countries.create');
        Route::post('/general/countries/store', [SettingController::class, 'storeCountry'])->name('settings.countries.store');
        Route::get('/general/countries/edit', [SettingController::class, 'editCountry'])->name('settings.countries.edit');
        Route::post('/general/countries/update', [SettingController::class, 'updateCountry'])->name('settings.countries.update');
        Route::delete('/general/countries/destroy/{id}', [SettingController::class, 'destroyCountry'])->name('settings.countries.destroy');
    });

    /* Centre Management */
    Route::prefix('centre-management')->group(function () {
        /* Centres */
        Route::get('/centres', [CentreController::class, 'index'])->name('centres')->middleware('permission:centre_view_access');
        Route::get('/centres/create', [CentreController::class, 'create'])->name('centres.create')->middleware('permission:centre_create_access');
        Route::post('/centres/store', [CentreController::class, 'store'])->name('centres.store')->middleware('permission:centre_create_access');
        Route::get('/centres/edit', [CentreController::class, 'edit'])->name('centres.edit')->middleware('permission:centre_edit_access');
        Route::post('/centres/update', [CentreController::class, 'update'])->name('centres.update')->middleware('permission:centre_edit_access');  
        Route::delete('/centres/destroy/{id}', [CentreController::class, 'destroy'])->name('centres.destroy')->middleware('permission:centre_delete_access');
        Route::delete('/centres/image/destroy/{id}', [CentreController::class, 'destroyImage'])->name('centres.destroy_image')->middleware('permission:centre_delete_access');
        Route::get('/centres/images', [CentreController::class, 'getCentreImages'])->name('centres.get_images')->middleware('permission:centre_view_access');
        Route::get('/centres/find-user', [CentreController::class, 'findUser'])->name('centres.find_user')->middleware('permission:centre_view_access');

        /* Programmes*/
        Route::get('/programmes', [ProgrammeController::class, 'programmeList'])->name('programmes')->middleware('permission:programme_view_access');
        Route::get('/programmes/create', [ProgrammeController::class, 'addProgramme'])->name('programmes.create')->middleware('permission:programme_create_access');
        Route::post('/programmes/store', [ProgrammeController::class, 'storeProgramme'])->name('programmes.store')->middleware('permission:programme_create_access');
        Route::get('/programmes/edit', [ProgrammeController::class, 'editProgramme'])->name('programmes.edit')->middleware('permission:programme_edit_access');
        Route::post('/programmes/update', [ProgrammeController::class, 'updateProgramme'])->name('programmes.update')->middleware('permission:programme_edit_access'); 
        Route::delete('/programmes/destroy/{id}', [ProgrammeController::class, 'destroyProgramme'])->name('programmes.destroy')->middleware('permission:programme_delete_access');
        Route::get('/programmes/get-fee', [ProgrammeController::class, 'getFee'])->name('programmes.get_fee')->middleware('permission:programme_view_access|programme_create_access|programme_edit_access');
        
        /* Classes */
        Route::get('/classes', [ClassController::class, 'index'])->name('classes')->middleware('permission:class_view_access');
        Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create')->middleware('permission:class_create_access');
        Route::post('/classes/store', [ClassController::class, 'store'])->name('classes.store')->middleware('permission:class_create_access');
        Route::get('/classes/edit', [ClassController::class, 'edit'])->name('classes.edit')->middleware('permission:class_edit_access');
        Route::post('/classes/update', [ClassController::class, 'update'])->name('classes.update')->middleware('permission:class_edit_access');  
        Route::delete('/classes/destroy/{id}', [ClassController::class, 'destroy'])->name('classes.destroy')->middleware('permission:class_delete_access');
        Route::get('/classes/get-class-types', [ClassController::class, 'getClassTypes'])->name('classes.get_class_types')->middleware('permission:class_view_access|class_create_access|class_edit_access');
        Route::get('/classes/get-class-levels', [ClassController::class, 'getClassLevels'])->name('classes.get_class_levels')->middleware('permission:class_view_access|class_create_access|class_edit_access');
        Route::get('/classes/find', [ClassController::class, 'findClasses'])->name('classes.find')->middleware('permission:class_view_access|class_create_access|class_edit_access');

        /* Students */
        Route::get('/students', [StudentController::class, 'index'])->name('students')->middleware('permission:student_view_access');
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create')->middleware('permission:student_create_access');
        Route::post('/students/store', [StudentController::class, 'store'])->name('students.store')->middleware('permission:student_create_access');
        Route::get('/students/edit', [StudentController::class, 'edit'])->name('students.edit')->middleware('permission:student_edit_access');
        Route::post('/students/update', [StudentController::class, 'update'])->name('students.update')->middleware('permission:student_edit_access');
        Route::delete('/students/destroy', [StudentController::class, 'destroy'])->name('students.destroy')->middleware('permission:student_delete_access');
        Route::get('/students/find', [StudentController::class, 'findStudents'])->name('students.find')->middleware('permission:student_view_access|student_create_access|student_edit_access');
        Route::post('/students/add-student-class', [StudentController::class, 'addStudentClass'])->name('students.add_student_class')->middleware('permission:student_view_access|student_create_access|student_edit_access');

        /* Settings */    
        Route::get('/settings', [SettingController::class, 'classTypeList'])->name('settings')->middleware('permission:setting_view_access');
            /* Class Types */
            Route::get('/settings/class_types', [SettingController::class, 'classTypeList'])->name('settings.class_types')->middleware('permission:setting_class_type_view_access');
            Route::get('/settings/class_types/create', [SettingController::class, 'addClassType'])->name('settings.class_types.create')->middleware('permission:setting_class_type_create_access');
            Route::post('/settings/class_types/store', [SettingController::class, 'storeClassType'])->name('settings.class_types.store')->middleware('permission:setting_class_type_create_access');
            Route::get('/settings/class_types/edit', [SettingController::class, 'editClassType'])->name('settings.class_types.edit')->middleware('permission:setting_class_type_edit_access');
            Route::post('/settings/class_types/update', [SettingController::class, 'updateClassType'])->name('settings.class_types.update')->middleware('permission:setting_class_type_edit_access');
            Route::delete('/settings/class_types/destroy/{id}', [SettingController::class, 'destroyClassType'])->name('settings.class_types.destroy')->middleware('permission:setting_class_type_delete_access');

    });

    /* External User Management */
    Route::prefix('external-user-management')->group(function () {
        Route::get('/division-manager', [ExternalUserManagementController::class, 'divisionManagerList'])->name('division_manager.users');
        Route::get('/division-manager/manage', [ExternalUserManagementController::class, 'manageDivisionManager'])->name('division_manager.manage');
        Route::post('/division-manager/manage/store', [ExternalUserManagementController::class, 'manageDivisionManagerStore'])->name('division_manager.store');

        Route::get('/centre-manager', [ExternalUserManagementController::class, 'centreManagerList'])->name('centre_manager.users');
        Route::get('/centre-manager/manage', [ExternalUserManagementController::class, 'manageCentreManager'])->name('centre_manager.manage');
        Route::post('/centre-manager/manage/store', [ExternalUserManagementController::class, 'manageCentreManagerStore'])->name('centre_manager.store');
    });

    
    /* Diagnostic Test Setting*/
    Route::prefix('diagnostic-test')->group(function () {

        /* Diagnostic Test List */
        Route::get('/settings', [DiagnosticTestController::class, 'dtList'])->name('dt.settings')->middleware('permission:view_dt_settings_access');
        Route::get('/settings/create', [DiagnosticTestController::class, 'dtCreate'])->name('dt.settings.create')->middleware('permission:create_dt_settings_access');
        Route::post('/settings/store', [DiagnosticTestController::class, 'dtStore'])->name('dt.settings.store')->middleware('permission:create_dt_settings_access');
        Route::get('/settings/edit', [DiagnosticTestController::class, 'dtEdit'])->name('dt.settings.edit')->middleware('permission:edit_dt_settings_access');
        Route::post('/settings/update', [DiagnosticTestController::class, 'dtUpdate'])->name('dt.settings.update')->middleware('permission:edit_dt_settings_access');
        Route::delete('/settings/destroy/{id}', [DiagnosticTestController::class, 'dtDestroy'])->name('dt.settings.destroy')->middleware('permission:delete_dt_settings_access');

        /* Diagnostic Test Detail List */
        Route::get('/settings/details', [DiagnosticTestController::class, 'dtDetailsList'])->name('dt.settings.details')->middleware('permission:view_dt_settings_access');
        Route::get('/settings/details/create', [DiagnosticTestController::class, 'dtDetailsCreate'])->name('dt.settings.details.create')->middleware('permission:create_dt_settings_access');
        Route::post('/settings/details/store', [DiagnosticTestController::class, 'dtDetailsStore'])->name('dt.settings.details.store')->middleware('permission:create_dt_settings_access');
        Route::get('/settings/details/edit', [DiagnosticTestController::class, 'dtDetailsEdit'])->name('dt.settings.details.edit')->middleware('permission:edit_dt_settings_access');
        Route::post('/settings/details/update', [DiagnosticTestController::class, 'dtDetailsUpdate'])->name('dt.settings.details.update')->middleware('permission:edit_dt_settings_access');
        Route::delete('/settings/details/destroy/{id}', [DiagnosticTestController::class, 'dtDetailsDestroy'])->name('dt.settings.details.destroy')->middleware('permission:delete_dt_settings_access');
        Route::post('/settings/details/sort', [DiagnosticTestController::class, 'dtDetailsSort'])->name('dt.settings.details.sort')->middleware('permission:view_dt_settings_access|edit_dt_settings_access');

        /* Diagnostic Test Detail Conditions */
        Route::get('/settings/conditions/create', [DiagnosticTestController::class, 'dtConditionsCreate'])->name('dt.settings.conditions.create')->middleware('permission:create_dt_settings_access');
        Route::post('/settings/conditions/store', [DiagnosticTestController::class, 'dtConditionsStore'])->name('dt.settings.conditions.store')->middleware('permission:create_dt_settings_access');
        Route::get('/settings/conditions/edit', [DiagnosticTestController::class, 'dtConditionsEdit'])->name('dt.settings.conditions.edit')->middleware('permission:edit_dt_settings_access');
        Route::post('/settings/conditions/update', [DiagnosticTestController::class, 'dtConditionsUpdate'])->name('dt.settings.conditions.update')->middleware('permission:edit_dt_settings_access');
        Route::delete('/settings/conditions/destroy/{id}', [DiagnosticTestController::class, 'dtConditionsDestroy'])->name('dt.settings.conditions.destroy')->middleware('permission:delete_dt_settings_access');

        /* Diagnostic Test Detail Categories */
        Route::get('/settings/categories/create', [DiagnosticTestController::class, 'dtCategoriesCreate'])->name('dt.settings.categories.create')->middleware('permission:create_dt_settings_access');
        Route::post('/settings/categories/store', [DiagnosticTestController::class, 'dtCategoriesStore'])->name('dt.settings.categories.store')->middleware('permission:create_dt_settings_access');
        Route::get('/settings/categories/edit', [DiagnosticTestController::class, 'dtCategoriesEdit'])->name('dt.settings.categories.edit')->middleware('permission:edit_dt_settings_access');
        Route::post('/settings/categories/update', [DiagnosticTestController::class, 'dtCategoriesUpdate'])->name('dt.settings.categories.update')->middleware('permission:edit_dt_settings_access');
        Route::delete('/settings/categories/destroy/{id}', [DiagnosticTestController::class, 'dtCategoriesDestroy'])->name('dt.settings.categories.destroy')->middleware('permission:delete_dt_settings_access');
    });
    
    /* Shop */
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/shop/cart', [ShopController::class, 'shopCart'])->name('shop.cart');
    Route::get('/shop/checkout', [ShopController::class, 'shopCheckout'])->name('shop.checkout');
    Route::post('/shop/payment', [ShopController::class, 'shopPayment'])->name('shop.payment');
    Route::get('/shop/payment/status', [ShopController::class, 'shopPaymentStatus'])->name('shop.payment.status');

    /* Notifications */
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/view', [NotificationController::class, 'viewNotification'])->name('view_notification');
    Route::get('/notifications/show-more', [NotificationController::class, 'showMoreNotifications'])->name('show_more_notifications');
    Route::delete('/notifications/delete', [NotificationController::class, 'deleteNotification'])->name('delete_notification');
});


Route::prefix('diagnostic-test')->group(function () {
    Route::get('/', [DiagnosticTestController::class, 'dtMain'])->middleware('auth')->name('diagnostic_test')->middleware('permission:view_test_access');
    Route::get('/public', [DiagnosticTestController::class, 'dtMain'])->name('public.diagnostic_test');
    Route::post('/start', [DiagnosticTestController::class, 'dtStart'])->name('diagnostic_test.run');
    Route::get('/new-level', [DiagnosticTestController::class, 'dtNewLevel'])->name('diagnostic_test.new_level');
    Route::post('/save-result', [DiagnosticTestController::class, 'saveDtResult'])->name('diagnostic_test.save_result');
    Route::get('/saved-result', [DiagnosticTestController::class, 'savedDtResult'])->name('diagnostic_test.saved_result');
    Route::post('/saved-result/save-status', [DiagnosticTestController::class, 'saveDtResultStatus'])->name('diagnostic_test.saved_result.save_status');
    Route::get('/saved-result/details', [DiagnosticTestController::class, 'savedDtResultDetails'])->name('diagnostic_test.saved_result.details');
    Route::get('/get-dt-categories', [DiagnosticTestController::class, 'getDtCategories'])->name('diagnostic_test.get_dt_categories');
    Route::get('/get-saved-result-info', [DiagnosticTestController::class, 'getSavedResultInfo'])->name('diagnostic_test.get_saved_result_info');
});

require __DIR__.'/auth.php';
