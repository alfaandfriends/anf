<?php

use App\Http\Controllers\ArtGalleryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosticTestController;
use App\Http\Controllers\ExternalUserManagementController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MathManipulativesController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariationItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\ProgressReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherResourcesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
    Route::prefix('admin')->group(function () {
        /* User Impersonation */
        Route::get('/impersonate/{user}', [AuthenticatedSessionController::class, 'impersonate'])->name('impersonate')->middleware('permission:impersonate_access');
        Route::get('/leave-impersonate', [AuthenticatedSessionController::class, 'leaveImpersonate'])->name('leave-impersonate')->middleware('permission:impersonate_access');

        /* Dashboard */
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view_dashboard');
        
        /* Administration */
        Route::prefix('administration')->middleware('permission:administration_access')->group(function () {
            /* Centres */
            Route::get('/centres', [CentreController::class, 'index'])->name('centres')->middleware('permission:view_centres');
            Route::get('/centres/create', [CentreController::class, 'create'])->name('centres.create')->middleware('permission:create_centres');
            Route::post('/centres/store', [CentreController::class, 'store'])->name('centres.store')->middleware('permission:create_centres');
            Route::get('/centres/edit', [CentreController::class, 'edit'])->name('centres.edit')->middleware('permission:edit_centres');
            Route::post('/centres/update', [CentreController::class, 'update'])->name('centres.update')->middleware('permission:edit_centres');
            Route::delete('/centres/destroy/{id}', [CentreController::class, 'destroy'])->name('centres.destroy')->middleware('permission:delete_centres');
            Route::delete('/centres/image/destroy/{id}', [CentreController::class, 'destroyImage'])->name('centres.destroy_image')->middleware('permission:delete_centres');
            Route::get('/centres/images', [CentreController::class, 'getCentreImages'])->name('centres.get_images')->middleware('permission:view_centres');
            // Route::get('/centres/find-user', [CentreController::class, 'findUser'])->name('centres.find_user')->middleware('permission:view_centres');

            /* Division Manager */
            Route::get('/division-manager', [ExternalUserManagementController::class, 'divisionManagerList'])->name('division_manager')->middleware('permission:view_division_manager');
            Route::get('/division-manager/manage', [ExternalUserManagementController::class, 'manageDivisionManager'])->name('division_manager.manage')->middleware('permission:manage_division_manager');
            Route::post('/division-manager/manage/store', [ExternalUserManagementController::class, 'manageDivisionManagerStore'])->name('division_manager.store')->middleware('permission:manage_division_manager');

            /* Centre Manager */
            Route::get('/centre-manager', [ExternalUserManagementController::class, 'centreManagerList'])->name('centre_manager')->middleware('permission:view_centre_manager');
            Route::get('/centre-manager/manage', [ExternalUserManagementController::class, 'manageCentreManager'])->name('centre_manager.manage')->middleware('permission:manage_centre_manager');
            Route::post('/centre-manager/manage/store', [ExternalUserManagementController::class, 'manageCentreManagerStore'])->name('centre_manager.store')->middleware('permission:manage_centre_manager');

            /* Edupreneurs */
            Route::get('/edupreneurs', [ExternalUserManagementController::class, 'edupreneurList'])->name('edupreneurs')->middleware('permission:view_edupreneurs');
            Route::get('/edupreneurs/manage', [ExternalUserManagementController::class, 'manageEdupreneur'])->name('edupreneurs.manage')->middleware('permission:manage_edupreneurs');
            Route::post('/edupreneurs/manage/store', [ExternalUserManagementController::class, 'manageEdupreneurStore'])->name('edupreneurs.store')->middleware('permission:manage_edupreneurs');
        });

        /* Academic */
        Route::prefix('academic')->middleware('permission:academic_access')->group(function () {
            /* Programmes*/
            Route::get('/programmes', [ProgrammeController::class, 'programmeList'])->name('programmes')->middleware('permission:view_programmes');
            Route::get('/programmes/create', [ProgrammeController::class, 'addProgramme'])->name('programmes.create')->middleware('permission:create_programmes');
            Route::post('/programmes/store', [ProgrammeController::class, 'storeProgramme'])->name('programmes.store')->middleware('permission:create_programmes');
            Route::get('/programmes/edit', [ProgrammeController::class, 'editProgramme'])->name('programmes.edit')->middleware('permission:edit_programmes');
            Route::post('/programmes/update', [ProgrammeController::class, 'updateProgramme'])->name('programmes.update')->middleware('permission:edit_programmes');
            Route::delete('/programmes/destroy/{id}', [ProgrammeController::class, 'destroyProgramme'])->name('programmes.destroy')->middleware('permission:delete_programmes');
            Route::get('/programmes/get-fee', [ProgrammeController::class, 'getFee'])->name('programmes.get_fee')->middleware('permission:view_programmes|create_programmes|delete_programmes');
            Route::delete('/programmes/fee/destroy/{id}', [ProgrammeController::class, 'destroyFee'])->name('programmes.fee.destroy')->middleware('permission:edit_programmes|delete_programmes');

            /* Classes */
            Route::get('/classes', [ClassController::class, 'index'])->name('classes')->middleware('permission:view_classes');
            Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create')->middleware('permission:create_classes');
            Route::post('/classes/store', [ClassController::class, 'store'])->name('classes.store')->middleware('permission:create_classes');
            Route::get('/classes/edit', [ClassController::class, 'edit'])->name('classes.edit')->middleware('permission:edit_classes');
            Route::post('/classes/update', [ClassController::class, 'update'])->name('classes.update')->middleware('permission:edit_classes');
            Route::delete('/classes/destroy/{id}', [ClassController::class, 'destroy'])->name('classes.destroy')->middleware('permission:delete_classes');
            Route::get('/classes/get-class-types', [ClassController::class, 'getClassTypes'])->name('classes.get_class_types')->middleware('permission:view_classes|create_classes|create_classes');
            Route::get('/classes/get-class-levels', [ClassController::class, 'getClassLevels'])->name('classes.get_class_levels')->middleware('permission:view_classes|create_classes|create_classes');
            Route::get('/classes/find', [ClassController::class, 'findClasses'])->name('classes.find')->middleware('permission:view_classes|create_classes|create_classes');

            /* Students */
            Route::get('/students', [StudentController::class, 'index'])->name('students')->middleware('permission:view_students');
            Route::get('/students/create', [StudentController::class, 'create'])->name('students.create')->middleware('permission:create_students');
            Route::post('/students/store', [StudentController::class, 'store'])->name('students.store')->middleware('permission:create_students');
            Route::get('/students/edit', [StudentController::class, 'edit'])->name('students.edit')->middleware('permission:edit_students');
            Route::post('/students/update', [StudentController::class, 'update'])->name('students.update')->middleware('permission:edit_students');
            Route::delete('/students/destroy', [StudentController::class, 'destroy'])->name('students.destroy')->middleware('permission:delete_students');
            Route::post('/students/add-student-class', [StudentController::class, 'addStudentClass'])->name('students.add_student_class')->middleware('permission:view_students|create_students|edit_students');
            Route::post('/students/set-fee-status', [StudentController::class, 'setFeeStatus'])->name('students.set_fee_status')->middleware('permission:view_students|create_students|edit_students');
            Route::post('/students/transfer', [StudentController::class, 'transferStudent'])->name('students.transfer')->middleware('permission:view_students|create_students|edit_students');

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

        /* Profile */
        Route::get('/profile', [ProfileController::class, 'create'])->name('profile');
        Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
        Route::post('/profile/security/store', [ProfileController::class, 'storeSecurity'])->name('profile.security.store');

        /* Children */
        Route::post('/children/store', [ChildrenController::class, 'store'])->name('children.store');
        Route::get('/children/edit', [ChildrenController::class, 'edit'])->name('children.edit');
        Route::post('/children/update', [ChildrenController::class, 'update'])->name('children.update');
        Route::delete('/children/delete/{id}', [ChildrenController::class, 'destroy'])->name('children.destroy');

        /* Countries */
        Route::get('/country', [CountryController::class, 'index'])->name('country');
        Route::get('/country/create', [CountryController::class, 'create'])->name('country.create');
        Route::post('/country/store', [CountryController::class, 'store'])->name('country.store');
        Route::get('/country/edit', [CountryController::class, 'edit'])->name('country.edit');
        Route::post('/country/update', [CountryController::class, 'update'])->name('country.update');
        Route::delete('/country/destroy/{id}', [CountryController::class, 'destroy'])->name('country.destroy');
        
        /* Control Panel */
        Route::prefix('control-panel')->group(function () {
            /* Users */
            Route::get('/users', [UserController::class, 'index'])->name('users')->middleware('permission:cp_users_view_access');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:cp_users_create_access');
            Route::post('/users/store', [UserController::class, 'store'])->name('users.store')->middleware('permission:cp_users_create_access');
            Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:cp_users_edit_access');
            Route::post('/users/update', [UserController::class, 'update'])->name('users.update')->middleware('permission:cp_users_edit_access');
            Route::post('/users/reset-user-password', [UserController::class, 'resetUserPassword'])->name('users.reset_user_password')->middleware('permission:cp_users_edit_access');
            Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:cp_users_delete_access');
            Route::post('/users/completed-tour', [UserController::class, 'completedTour'])->name('users.completed_tour');
            Route::get('/get-user-info/{id}', [UserController::class, 'getUserInfo'])->name('users.get_info');

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

        /* Products */
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::post('/products/update', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::delete('/products/variation/delete/{id}', [ProductController::class, 'deleteVariation'])->name('products.delete_variation');
        Route::delete('/products/sub-variation/delete', [ProductController::class, 'deleteSubVariation'])->name('products.delete_sub_variation');
        Route::get('/products/get-product-data-by-fee', [ProductHelper::class, 'getProductDataByFee'])->name('products.get_product_data_by_fee');

        /* Orders */
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::post('/orders/update', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/orders/delete/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('/orders/invoice/generate', [OrderController::class, 'generateInvoice'])->name('orders.invoice.generate');
        Route::get('/orders/packing-slip/generate', [OrderController::class, 'generatePackingSlip'])->name('orders.packing_slip.generate');

        /* Notifications */
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::get('/notifications/view', [NotificationController::class, 'viewNotification'])->name('view_notification');
        Route::get('/notifications/show-more', [NotificationController::class, 'showMoreNotifications'])->name('show_more_notifications');
        Route::delete('/notifications/delete', [NotificationController::class, 'deleteNotification'])->name('delete_notification');

        /* Art Gallery */
        Route::get('/art-gallery', [ArtGalleryController::class, 'index'])->name('art_gallery');
        Route::get('/art-gallery/create', [ArtGalleryController::class, 'create'])->name('art_gallery.create');
        Route::post('/art-gallery/store', [ArtGalleryController::class, 'store'])->name('art_gallery.store');
        Route::delete('/art-gallery/destroy/{id}', [ArtGalleryController::class, 'destroy'])->name('art_gallery.destroy');
        Route::get('/art-gallery/get_themes/{id}', [ArtGalleryController::class, 'getThemes'])->name('art_gallery.get_themes');
        Route::get('/art-gallery/get_lessons/{id}', [ArtGalleryController::class, 'getLessons'])->name('art_gallery.get_lessons');
        Route::get('/art-gallery/get_activities/{id}', [ArtGalleryController::class, 'getActivities'])->name('art_gallery.get_activities');

        /* Math Manipulatives */
        Route::get('/math-manipulatives', [MathManipulativesController::class, 'index'])->name('math_manipulatives');
        Route::get('/math-manipulatives/play', [MathManipulativesController::class, 'play'])->name('math_manipulatives.play');
        Route::get('/math-manipulatives/configuration', [MathManipulativesController::class, 'configuration'])->name('math_manipulatives.configuration');
        Route::get('/math-manipulatives/configuration/create', [MathManipulativesController::class, 'configurationCreate'])->name('math_manipulatives.configuration.create');
        Route::post('/math-manipulatives/configuration/store', [MathManipulativesController::class, 'configurationStore'])->name('math_manipulatives.configuration.store');
        Route::delete('/math-manipulatives/configuration/delete/{id}', [MathManipulativesController::class, 'configurationDelete'])->name('math_manipulatives.configuration.delete');

        /* Teacher Resources */
        Route::get('/teacher-resources', [TeacherResourcesController::class, 'index'])->name('teacher_resources');
        Route::get('/teacher-resources/create', [TeacherResourcesController::class, 'create'])->name('teacher_resources.create');
        Route::post('/teacher-resources/store', [TeacherResourcesController::class, 'store'])->name('teacher_resources.store');
        Route::get('/teacher-resources/edit', [TeacherResourcesController::class, 'edit'])->name('teacher_resources.edit');
        Route::post('/teacher-resources/update', [TeacherResourcesController::class, 'update'])->name('teacher_resources.update');
        Route::delete('/teacher-resources/destroy/{id}', [TeacherResourcesController::class, 'destroy'])->name('teacher_resources.destroy');
        Route::get('/teacher-resources/get-resource', [TeacherResourcesController::class, 'getResource'])->name('teacher_resources.get_resource');

        /* Invoices */
        Route::get('/invoices/fee', [InvoiceController::class, 'feeInvoiceIndex'])->name('fee.invoices');
        Route::get('/invoices/fee/create', [InvoiceController::class, 'feeInvoiceCreate'])->name('fee.invoices.create');
        Route::post('/invoices/fee/store', [InvoiceController::class, 'feeInvoiceStore'])->name('fee.invoices.store');
        Route::get('/invoices/fee/edit', [InvoiceController::class, 'feeInvoiceEdit'])->name('fee.invoices.edit');
        Route::post('/invoices/fee/update', [InvoiceController::class, 'feeInvoiceUpdate'])->name('fee.invoices.update');
        Route::get('/invoices/fee_invoice/generate', [InvoiceController::class, 'feeInvoiceGenerate'])->name('fee.invoices.generate');

        /* Progress Report */
        Route::get('/progress-report', [ProgressReportController::class, 'index'])->name('progress_report');
        Route::get('/progress-report/details', [ProgressReportController::class, 'details'])->name('progress_report.details');
        Route::get('/progress-report/full-reports', [ProgressReportController::class, 'getFullProgressReports'])->name('progress_report.full_reports');


        Route::post('/progress-report/store', [ProgressReportController::class, 'store'])->name('progress_report.store');
    });
});
