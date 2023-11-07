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
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\ProgressReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherResourcesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::middleware(['auth', 'device'])->group(function(){
    Route::prefix('admin')->group(function () {
        /* User Impersonation */
        Route::get('/impersonate/{user}', [AuthenticatedSessionController::class, 'impersonate'])->name('impersonate');
        Route::get('/leave-impersonate', [AuthenticatedSessionController::class, 'leaveImpersonate'])->name('leave-impersonate');

        /* Dashboard */
        Route::get('/', function () {
            return redirect(route('dashboard'));
        });
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
        });

        /* Students */
        Route::prefix('students')->middleware('permission:student_access')->group(function () {
            /* Students */
            Route::get('/', [StudentController::class, 'index'])->name('students')->middleware('permission:view_students');
            Route::get('/create', [StudentController::class, 'create'])->name('students.create')->middleware('permission:create_students');
            Route::post('/store', [StudentController::class, 'store'])->name('students.store')->middleware('permission:create_students');
            Route::get('/edit', [StudentController::class, 'edit'])->name('students.edit')->middleware('permission:edit_students');
            Route::post('/update', [StudentController::class, 'update'])->name('students.update')->middleware('permission:edit_students');
            Route::delete('/destroy', [StudentController::class, 'destroy'])->name('students.destroy')->middleware('permission:delete_students');
            Route::post('/add-student-class', [StudentController::class, 'addStudentClass'])->name('students.add_student_class')->middleware('permission:view_students|create_students|edit_students');
            Route::post('/set-fee-status', [StudentController::class, 'setFeeStatus'])->name('students.set_fee_status')->middleware('permission:view_students|create_students|edit_students');
            Route::post('/transfer', [StudentController::class, 'transferStudent'])->name('students.transfer')->middleware('permission:view_students|create_students|edit_students');
            
            /* Art Gallery */
            Route::get('/art-gallery', [ArtGalleryController::class, 'index'])->name('art_gallery')->middleware('permission:view_art_gallery');
            Route::get('/art-gallery/create', [ArtGalleryController::class, 'create'])->name('art_gallery.create')->middleware('permission:create_art_gallery');
            Route::post('/art-gallery/store', [ArtGalleryController::class, 'store'])->name('art_gallery.store')->middleware('permission:create_art_gallery');
            Route::delete('/art-gallery/destroy/{id}', [ArtGalleryController::class, 'destroy'])->name('art_gallery.destroy')->middleware('permission:delete_art_gallery');

            Route::get('/art-gallery/get_levels/{id}', [ArtGalleryController::class, 'getLevels'])->name('art_gallery.get_levels')->middleware('permission:view_art_gallery');
            Route::get('/art-gallery/get_themes/{id}', [ArtGalleryController::class, 'getThemes'])->name('art_gallery.get_themes')->middleware('permission:view_art_gallery');
            Route::get('/art-gallery/get_lessons/{id}', [ArtGalleryController::class, 'getLessons'])->name('art_gallery.get_lessons')->middleware('permission:view_art_gallery');
            Route::get('/art-gallery/get_activities/{id}', [ArtGalleryController::class, 'getActivities'])->name('art_gallery.get_activities')->middleware('permission:view_art_gallery');

            /* Setting */
                /* Level, Theme, Lesson, Activity List */
                Route::get('/art-gallery/setting/levels', [ArtGalleryController::class, 'levels'])->name('art_gallery.setting.levels')->middleware('permission:view_art_gallery');
                Route::get('/art-gallery/setting/themes', [ArtGalleryController::class, 'themes'])->name('art_gallery.setting.themes')->middleware('permission:view_art_gallery');
                Route::get('/art-gallery/setting/lessons', [ArtGalleryController::class, 'lessons'])->name('art_gallery.setting.lessons')->middleware('permission:view_art_gallery');
                Route::get('/art-gallery/setting/activities', [ArtGalleryController::class, 'activities'])->name('art_gallery.setting.activities')->middleware('permission:view_art_gallery');
                
                /* Level, Theme, Lesson, Activity Store */
                Route::post('/art-gallery/setting/levels/store', [ArtGalleryController::class, 'levelStore'])->name('art_gallery.setting.levels.store')->middleware('permission:view_art_gallery');
                Route::post('/art-gallery/setting/themes/store', [ArtGalleryController::class, 'themeStore'])->name('art_gallery.setting.themes.store')->middleware('permission:view_art_gallery');
                Route::post('/art-gallery/setting/lessons/store', [ArtGalleryController::class, 'lessonStore'])->name('art_gallery.setting.lessons.store')->middleware('permission:view_art_gallery');
                Route::post('/art-gallery/setting/activities/store', [ArtGalleryController::class, 'activityStore'])->name('art_gallery.setting.activities.store')->middleware('permission:view_art_gallery');

                /* Level, Theme, Lesson, Activity Update */
                Route::post('/art-gallery/setting/levels/update', [ArtGalleryController::class, 'levelUpdate'])->name('art_gallery.setting.levels.update')->middleware('permission:view_art_gallery');
                Route::post('/art-gallery/setting/themes/update', [ArtGalleryController::class, 'themeUpdate'])->name('art_gallery.setting.themes.update')->middleware('permission:view_art_gallery');
                Route::post('/art-gallery/setting/lessons/update', [ArtGalleryController::class, 'lessonUpdate'])->name('art_gallery.setting.lessons.update')->middleware('permission:view_art_gallery');
                Route::post('/art-gallery/setting/activities/update', [ArtGalleryController::class, 'activityUpdate'])->name('art_gallery.setting.activities.update')->middleware('permission:view_art_gallery');

                /* Level, Theme, Lesson, Activity Delete */
                Route::delete('/art-gallery/setting/levels/delete/{id}', [ArtGalleryController::class, 'levelDelete'])->name('art_gallery.setting.levels.delete')->middleware('permission:view_art_gallery');
                Route::delete('/art-gallery/setting/themes/delete/{id}', [ArtGalleryController::class, 'themeDelete'])->name('art_gallery.setting.themes.delete')->middleware('permission:view_art_gallery');
                Route::delete('/art-gallery/setting/lessons/delete/{id}', [ArtGalleryController::class, 'lessonDelete'])->name('art_gallery.setting.lessons.delete')->middleware('permission:view_art_gallery');
                Route::delete('/art-gallery/setting/activities/delete/{id}', [ArtGalleryController::class, 'activityDelete'])->name('art_gallery.setting.activities.delete')->middleware('permission:view_art_gallery');


            /* Progress Report */
            Route::get('/progress-report', [ProgressReportController::class, 'index'])->name('progress_report')->middleware('permission:view_progress_report');
            Route::get('/progress-report/details', [ProgressReportController::class, 'details'])->name('progress_report.details')->middleware('permission:view_progress_report');
            Route::get('/progress-report/full-reports', [ProgressReportController::class, 'getFullProgressReports'])->name('progress_report.full_reports')->middleware('permission:view_progress_report');
            Route::post('/progress-report/store', [ProgressReportController::class, 'store'])->name('progress_report.store')->middleware('permission:view_progress_report');
        });

        /* Resources */
        Route::prefix('resources')->middleware('permission:resources_access')->group(function () {
            /* Teacher Resources */
            Route::get('/teacher-resources', [TeacherResourcesController::class, 'index'])->name('teacher_resources')->middleware('permission:view_teacher_resources');
            Route::get('/teacher-resources/create', [TeacherResourcesController::class, 'create'])->name('teacher_resources.create')->middleware('permission:view_teacher_resources');
            Route::post('/teacher-resources/store', [TeacherResourcesController::class, 'store'])->name('teacher_resources.store')->middleware('permission:view_teacher_resources');
            Route::get('/teacher-resources/edit', [TeacherResourcesController::class, 'edit'])->name('teacher_resources.edit')->middleware('permission:view_teacher_resources');
            Route::post('/teacher-resources/update', [TeacherResourcesController::class, 'update'])->name('teacher_resources.update')->middleware('permission:view_teacher_resources');
            Route::delete('/teacher-resources/destroy/{id}', [TeacherResourcesController::class, 'destroy'])->name('teacher_resources.destroy')->middleware('permission:view_teacher_resources');
            Route::get('/teacher-resources/get-resource', [TeacherResourcesController::class, 'getResource'])->name('teacher_resources.get_resource')->middleware('permission:view_teacher_resources');
            
            /* Math Manipulatives */
            Route::get('/math-manipulatives', [MathManipulativesController::class, 'index'])->name('math_manipulatives')->middleware('permission:view_math_manipulatives');
            Route::get('/math-manipulatives/play', [MathManipulativesController::class, 'play'])->name('math_manipulatives.play')->middleware('permission:view_math_manipulatives');
            Route::get('/math-manipulatives/configuration', [MathManipulativesController::class, 'configuration'])->name('math_manipulatives.configuration')->middleware('permission:create_math_manipulatives');
            Route::get('/math-manipulatives/configuration/create', [MathManipulativesController::class, 'configurationCreate'])->name('math_manipulatives.configuration.create')->middleware('permission:create_math_manipulatives');
            Route::post('/math-manipulatives/configuration/store', [MathManipulativesController::class, 'configurationStore'])->name('math_manipulatives.configuration.store')->middleware('permission:create_math_manipulatives');
            Route::delete('/math-manipulatives/configuration/delete/{id}', [MathManipulativesController::class, 'configurationDelete'])->name('math_manipulatives.configuration.delete')->middleware('permission:create_math_manipulatives');
        });

        /* Diagnostic Test Setting*/
        Route::prefix('diagnostic-test')->middleware('permission:diagnostic_test_access')->group(function () {
            /* Diagnostic Test List */
            Route::get('/settings', [DiagnosticTestController::class, 'dtList'])->name('dt.settings');
            Route::get('/settings/create', [DiagnosticTestController::class, 'dtCreate'])->name('dt.settings.create');
            Route::post('/settings/store', [DiagnosticTestController::class, 'dtStore'])->name('dt.settings.store');
            Route::get('/settings/edit', [DiagnosticTestController::class, 'dtEdit'])->name('dt.settings.edit');
            Route::post('/settings/update', [DiagnosticTestController::class, 'dtUpdate'])->name('dt.settings.update');
            Route::delete('/settings/destroy/{id}', [DiagnosticTestController::class, 'dtDestroy'])->name('dt.settings.destroy');

            /* Diagnostic Test Detail List */
            Route::get('/settings/details', [DiagnosticTestController::class, 'dtDetailsList'])->name('dt.settings.details');
            Route::get('/settings/details/create', [DiagnosticTestController::class, 'dtDetailsCreate'])->name('dt.settings.details.create');
            Route::post('/settings/details/store', [DiagnosticTestController::class, 'dtDetailsStore'])->name('dt.settings.details.store');
            Route::get('/settings/details/edit', [DiagnosticTestController::class, 'dtDetailsEdit'])->name('dt.settings.details.edit');
            Route::post('/settings/details/update', [DiagnosticTestController::class, 'dtDetailsUpdate'])->name('dt.settings.details.update');
            Route::delete('/settings/details/destroy/{id}', [DiagnosticTestController::class, 'dtDetailsDestroy'])->name('dt.settings.details.destroy');
            Route::post('/settings/details/sort', [DiagnosticTestController::class, 'dtDetailsSort'])->name('dt.settings.details.sort');

            /* Diagnostic Test Detail Conditions */
            Route::get('/settings/conditions/create', [DiagnosticTestController::class, 'dtConditionsCreate'])->name('dt.settings.conditions.create');
            Route::post('/settings/conditions/store', [DiagnosticTestController::class, 'dtConditionsStore'])->name('dt.settings.conditions.store');
            Route::get('/settings/conditions/edit', [DiagnosticTestController::class, 'dtConditionsEdit'])->name('dt.settings.conditions.edit');
            Route::post('/settings/conditions/update', [DiagnosticTestController::class, 'dtConditionsUpdate'])->name('dt.settings.conditions.update');
            Route::delete('/settings/conditions/destroy/{id}', [DiagnosticTestController::class, 'dtConditionsDestroy'])->name('dt.settings.conditions.destroy');

            /* Diagnostic Test Detail Categories */
            Route::get('/settings/categories/create', [DiagnosticTestController::class, 'dtCategoriesCreate'])->name('dt.settings.categories.create');
            Route::post('/settings/categories/store', [DiagnosticTestController::class, 'dtCategoriesStore'])->name('dt.settings.categories.store');
            Route::get('/settings/categories/edit', [DiagnosticTestController::class, 'dtCategoriesEdit'])->name('dt.settings.categories.edit');
            Route::post('/settings/categories/update', [DiagnosticTestController::class, 'dtCategoriesUpdate'])->name('dt.settings.categories.update');
            Route::delete('/settings/categories/destroy/{id}', [DiagnosticTestController::class, 'dtCategoriesDestroy'])->name('dt.settings.categories.destroy');
        });

        /* Accounting */
        Route::prefix('accounting')->middleware('permission:accounting_access')->group(function () {
            Route::get('/fee_invoices', [InvoiceController::class, 'feeInvoiceIndex'])->name('fee.invoices')->middleware('permission:view_fee_invoices');
            Route::get('/fee_invoices/create', [InvoiceController::class, 'feeInvoiceCreate'])->name('fee.invoices.create')->middleware('permission:create_fee_invoices');
            Route::post('/fee_invoices/store', [InvoiceController::class, 'feeInvoiceStore'])->name('fee.invoices.store')->middleware('permission:create_fee_invoices');
            Route::get('/fee_invoices/edit', [InvoiceController::class, 'feeInvoiceEdit'])->name('fee.invoices.edit')->middleware('permission:edit_fee_invoices');
            Route::post('/fee_invoices/update', [InvoiceController::class, 'feeInvoiceUpdate'])->name('fee.invoices.update')->middleware('permission:edit_fee_invoices');
            Route::get('/fee_invoices/generate', [InvoiceController::class, 'feeInvoiceGenerate'])->name('fee.invoices.generate')->middleware('permission:view_fee_invoices');
        });
        
        /* Products */
        Route::prefix('products')->middleware('permission:product_access')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('products')->middleware('permission:view_products');
            Route::get('/create', [ProductController::class, 'create'])->name('products.create')->middleware('permission:create_products');
            Route::post('/store', [ProductController::class, 'store'])->name('products.store')->middleware('permission:create_products');
            Route::get('/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('permission:edit_products');
            Route::post('/update', [ProductController::class, 'update'])->name('products.update')->middleware('permission:edit_products');
            Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('permission:delete_products');
            Route::delete('/variation/delete/{id}', [ProductController::class, 'deleteVariation'])->name('products.delete_variation')->middleware('permission:view_products|create_products|edit_products|delete_products');
            Route::delete('/sub-variation/delete', [ProductController::class, 'deleteSubVariation'])->name('products.delete_sub_variation')->middleware('permission:view_products|create_products|edit_products|delete_products');
        });

        /* Orders */
        Route::prefix('orders')->middleware('permission:order_access')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('orders')->middleware('permission:view_orders');
            Route::get('/create', [OrderController::class, 'create'])->name('orders.create')->middleware('permission:create_orders');
            Route::post('/store', [OrderController::class, 'store'])->name('orders.store')->middleware('permission:create_orders');
            Route::get('/edit', [OrderController::class, 'edit'])->name('orders.edit')->middleware('permission:edit_orders');
            Route::post('/update', [OrderController::class, 'update'])->name('orders.update')->middleware('permission:edit_orders');
            Route::delete('/delete/{id}', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('permission:delete_orders');
            Route::get('/invoice/generate', [OrderController::class, 'generateInvoice'])->name('orders.invoice.generate')->middleware('permission:view_orders');
            Route::get('/packing-slip/generate', [OrderController::class, 'generatePackingSlip'])->name('orders.packing_slip.generate')->middleware('permission:view_orders');
        });

        /* Users */
        Route::get('/users', [UserController::class, 'index'])->name('users')->middleware('permission:view_users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:create_users');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store')->middleware('permission:create_users');
        Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:edit_users');
        Route::post('/users/update', [UserController::class, 'update'])->name('users.update')->middleware('permission:edit_users');
        Route::post('/users/reset-user-password', [UserController::class, 'resetUserPassword'])->name('users.reset_user_password')->middleware('permission:edit_users');
        Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:delete_users');
        Route::post('/users/completed-tour', [UserController::class, 'completedTour'])->name('users.completed_tour');
        Route::get('/get-user-info/{id}', [UserController::class, 'getUserInfo'])->name('users.get_info')->middleware('permission:view_users');

        /* Countries */
        Route::get('/countries', [CountryController::class, 'index'])->name('countries')->middleware('permission:view_country');
        Route::get('/countries/create', [CountryController::class, 'create'])->name('countries.create')->middleware('permission:create_country');
        Route::post('/countries/store', [CountryController::class, 'store'])->name('countries.store')->middleware('permission:create_country');
        Route::delete('/countries/destroy/{id}', [CountryController::class, 'destroy'])->name('countries.destroy')->middleware('permission:delete_country');

        /* Control Panel */
        Route::prefix('control-panel')->middleware('permission:control_panel_access')->group(function () {
            /* Roles */
            Route::get('/roles', [RoleController::class, 'index'])->name('roles')->middleware('permission:view_roles');
            Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:create_roles');
            Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:create_roles');
            Route::get('/roles/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:edit_roles');
            Route::post('/roles/update', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:edit_roles');
            Route::delete('/roles/destroy/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:delete_roles');
            Route::get('/roles/assign-permissions', [RoleController::class, 'assignPermissions'])->name('roles.assign_pemissions')->middleware('permission:manage_roles');
            Route::post('/roles/assign-permissions/store', [RoleController::class, 'assignPermissionsStore'])->name('roles.assign_permissions.store')->middleware('permission:manage_roles');

            /* Permissions */
            Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions')->middleware('permission:view_permissions');
            Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:create_permissions');
            Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:create_permissions');
            Route::get('/permissions/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:edit_permissions');
            Route::post('/permissions/update', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:edit_permissions');
            Route::delete('/permissions/destroy/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:delete_permissions');

            /* Menus */
            Route::get('/menus', [MenuController::class, 'index'])->name('menus')->middleware('permission:view_menu_editor');
            Route::get('/menus/add-menu', [MenuController::class, 'addMenu'])->name('menus.add_menu')->middleware('permission:create_menu_editor');
            Route::post('/menus/add-menu/store', [MenuController::class, 'storeMenu'])->name('menus.store_menu')->middleware('permission:create_menu_editor');
            Route::get('/menus/add-sub-menu', [MenuController::class, 'addSubMenu'])->name('menus.add_sub_menu')->middleware('permission:create_menu_editor');
            Route::post('/menus/add-sub-menu/store', [MenuController::class, 'storeSubMenu'])->name('menus.store_sub_menu')->middleware('permission:create_menu_editor');
            Route::get('/menus/edit-menu', [MenuController::class, 'editMenu'])->name('menus.edit_menu')->middleware('permission:edit_menu_editor');
            Route::post('/menus/edit-menu/update', [MenuController::class, 'updateMenu'])->name('menus.update_menu')->middleware('permission:edit_menu_editor');
            Route::get('/menus/edit-sub-menu', [MenuController::class, 'editSubMenu'])->name('menus.edit_sub_menu')->middleware('permission:edit_menu_editor');
            Route::post('/menus/edit-sub-menu/update', [MenuController::class, 'updateSubMenu'])->name('menus.update_sub_menu')->middleware('permission:edit_menu_editor');
            Route::delete('/menus/destroy-menu/{id}', [MenuController::class, 'destroyMenu'])->name('menus.destroy_menu')->middleware('permission:delete_menu_editor');
            Route::delete('/menus/destroy-sub-menu/{id}', [MenuController::class, 'destroySubMenu'])->name('menus.destroy_sub_menu')->middleware('permission:delete_menu_editor');
            Route::post('/menus/swap-menu/up', [MenuController::class, 'swapMenuUp'])->name('menus.swap_menu_up')->middleware('permission:view_menu_editor|create_menu_editor|edit_menu_editor');
            Route::post('/menus/swap-menu/down', [MenuController::class, 'swapMenuDown'])->name('menus.swap_menu_down')->middleware('permission:view_menu_editor|create_menu_editor|edit_menu_editor');
            Route::post('/menus/swap-sub-menu/up', [MenuController::class, 'swapSubMenuUp'])->name('menus.swap_sub_menu_up')->middleware('permission:view_menu_editor|create_menu_editor|edit_menu_editor');
            Route::post('/menus/swap-sub-menu/down', [MenuController::class, 'swapSubMenuDown'])->name('menus.swap_sub_menu_down')->middleware('permission:view_menu_editor|create_menu_editor|edit_menu_editor');

        });
        

        /* Profile */
        Route::get('/profile', [ProfileController::class, 'create'])->name('profile');
        Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store')->withoutMiddleware('device');
        Route::post('/profile/security/store', [ProfileController::class, 'storeSecurity'])->name('profile.security.store')->withoutMiddleware('device');

        /* Children */
        Route::post('/children/store', [ChildrenController::class, 'store'])->name('children.store')->withoutMiddleware('device');
        Route::get('/children/edit', [ChildrenController::class, 'edit'])->name('children.edit')->withoutMiddleware('device');
        Route::post('/children/update', [ChildrenController::class, 'update'])->name('children.update')->withoutMiddleware('device');
        Route::delete('/children/delete/{id}', [ChildrenController::class, 'destroy'])->name('children.destroy')->withoutMiddleware('device');

        /* Notifications */
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::get('/notifications/view', [NotificationController::class, 'viewNotification'])->name('view_notification');
        Route::get('/notifications/show-more', [NotificationController::class, 'showMoreNotifications'])->name('show_more_notifications');
        Route::delete('/notifications/delete', [NotificationController::class, 'deleteNotification'])->name('delete_notification');

        /* Temporary Disabled */
        Route::get('/settings/class_types', [SettingController::class, 'classTypeList'])->name('settings.class_types');
        Route::get('/settings/class_types/create', [SettingController::class, 'addClassType'])->name('settings.class_types.create');
        Route::post('/settings/class_types/store', [SettingController::class, 'storeClassType'])->name('settings.class_types.store');
        Route::get('/settings/class_types/edit', [SettingController::class, 'editClassType'])->name('settings.class_types.edit');
        Route::post('/settings/class_types/update', [SettingController::class, 'updateClassType'])->name('settings.class_types.update');
        Route::delete('/settings/class_types/destroy/{id}', [SettingController::class, 'destroyClassType'])->name('settings.class_types.destroy');
    });
});
