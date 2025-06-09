<?php

use App\Classes\ClassHelper;
use App\Classes\ProgrammeHelper;
use App\Classes\StoryHelper;
use App\Events\Notifications;
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
use App\Http\Controllers\ArtBookController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\ProgressReport\ArtDigitalSettingController;
use App\Http\Controllers\ProgressReport\ArtTraditionalSettingController;
use App\Http\Controllers\ProgressReport\CodingRoboticSettingController;
use App\Http\Controllers\ProgressReport\DigitalArtSettingController;
use App\Http\Controllers\ProgressReport\LittleArtistSettingController;
use App\Http\Controllers\ProgressReport\LittleBotSettingController;
use App\Http\Controllers\ProgressReport\MathSettingController;
use App\Http\Controllers\ProgressReport\ProgressReportController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\QRcodeGenerateController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherResourcesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Opcodes\LogViewer\Logs\Log;

Route::middleware(['auth'])->group(function(){
    Route::prefix('admin')->group(function () {
        /* User Impersonation */
        Route::get('/impersonate/{user}', [AuthenticatedSessionController::class, 'impersonate'])->name('impersonate');
        Route::get('/leave-impersonate', [AuthenticatedSessionController::class, 'leaveImpersonate'])->name('leave-impersonate');

        /* Dashboard */
        Route::get('/', function () {
            return redirect(route('dashboard'));
        });
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view_dashboard');
        Route::get('/dashboard/centres-data', [DashboardController::class, 'centresData'])->name('dashboard.centres_data')->middleware('permission:view_dashboard');
        
        /* Administration */
        Route::prefix('administration')->middleware('permission:administration_access')->group(function () {
            /* Centres */
            Route::prefix('centres')->group(function () {
                Route::get('/', [CentreController::class, 'index'])->name('centres')->middleware('permission:view_centres');
                Route::get('create', [CentreController::class, 'create'])->name('centres.create')->middleware('permission:create_centres');
                Route::post('store', [CentreController::class, 'store'])->name('centres.store')->middleware('permission:create_centres');
                Route::get('edit', [CentreController::class, 'edit'])->name('centres.edit')->middleware('permission:edit_centres');
                Route::post('update', [CentreController::class, 'update'])->name('centres.update')->middleware('permission:edit_centres');
                Route::delete('destroy/{id}', [CentreController::class, 'destroy'])->name('centres.destroy')->middleware('permission:delete_centres');
                Route::delete('image/destroy/{id}', [CentreController::class, 'destroyImage'])->name('centres.destroy_image')->middleware('permission:delete_centres');
            });
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
            
            /* Teachers */
            Route::get('/teachers', [ExternalUserManagementController::class, 'teacherList'])->name('teachers')->middleware('permission:view_edupreneurs');
            Route::get('/teachers/manage', [ExternalUserManagementController::class, 'manageTeacher'])->name('teachers.manage')->middleware('permission:manage_edupreneurs');
            Route::post('/teachers/manage/store', [ExternalUserManagementController::class, 'manageTeacherStore'])->name('teachers.store')->middleware('permission:manage_edupreneurs');
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
            Route::delete('/programmes/fee/destroy/{id}', [ProgrammeController::class, 'destroyFee'])->name('programmes.fee.destroy')->middleware('permission:edit_programmes|delete_programmes');
            Route::patch('/programmes/fee/old/update', [ProgrammeController::class, 'updateOldFee'])->name('programmes.old_fee.update')->middleware('permission:edit_programmes');
            Route::patch('/programmes/fee/new/update', [ProgrammeController::class, 'updateNewFee'])->name('programmes.new_fee.update')->middleware('permission:edit_programmes');
            Route::get('/programmes/get-students/{programme_id}/{centre_id}/{level_id?}', [ProgrammeHelper::class, 'getStudents'])->name('programmes.get_students');

            /* Classes */
            Route::get('/classes', [ClassController::class, 'index'])->name('classes')->middleware('permission:view_classes');
            Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create')->middleware('permission:create_classes');
            Route::post('/classes/store', [ClassController::class, 'store'])->name('classes.store')->middleware('permission:create_classes');
            Route::get('/classes/edit', [ClassController::class, 'edit'])->name('classes.edit')->middleware('permission:edit_classes');
            Route::post('/classes/update', [ClassController::class, 'update'])->name('classes.update')->middleware('permission:edit_classes');
            Route::delete('/classes/destroy/{id}', [ClassController::class, 'destroy'])->name('classes.destroy')->middleware('permission:delete_classes');
        });

        /* Students */
        Route::prefix('students')->middleware('permission:student_access')->group(function () {
            /* Students */
            Route::get('/', [StudentController::class, 'index'])->name('students')->middleware('permission:view_students');
            Route::get('/inactive', [StudentController::class, 'inactive'])->name('students.inactive')->middleware('permission:view_students');
            Route::get('/unassigned', [StudentController::class, 'unassigned'])->name('students.unassigned')->middleware('permission:view_students');
            Route::get('/create', [StudentController::class, 'create'])->name('students.create')->middleware('permission:create_students');
            Route::post('/store', [StudentController::class, 'store'])->name('students.store')->middleware('permission:create_students');
            Route::get('/edit', [StudentController::class, 'edit'])->name('students.edit')->middleware('permission:edit_students');
            Route::post('/update', [StudentController::class, 'update'])->name('students.update')->middleware('permission:edit_students');
            Route::post('/destroy', [StudentController::class, 'destroy'])->name('students.destroy')->middleware('permission:delete_students');
            Route::post('/add-student-class', [StudentController::class, 'addStudentClass'])->name('students.add_student_class')->middleware('permission:view_students|create_students|edit_students');
            Route::post('/set-fee-status', [StudentController::class, 'setFeeStatus'])->name('students.set_fee_status')->middleware('permission:view_students|create_students|edit_students');
            Route::post('/transfer', [StudentController::class, 'transferStudent'])->name('students.transfer')->middleware('permission:view_students|create_students|edit_students');
            Route::post('/add-promo', [StudentController::class, 'addPromo'])->name('students.add_promo')->middleware('permission:view_students|create_students|edit_students');
            Route::post('/delete-promo', [StudentController::class, 'deletePromo'])->name('students.delete_promo')->middleware('permission:view_students|create_students|edit_students');

            Route::get('/generate-monthly', [StudentController::class, 'generateMonthly'])->name('students.generate_monthly')->middleware('permission:view_students');
            
            /* Art Gallery */
            Route::get('/art-gallery', [ArtGalleryController::class, 'index'])->name('art_gallery')->middleware('permission:view_art_gallery');
            // Route::post('/art-gallery/store', [ArtGalleryController::class, 'store'])->name('art_gallery.store')->middleware('permission:create_art_gallery');
            // Route::delete('/art-gallery/destroy/{id}', [ArtGalleryController::class, 'destroy'])->name('art_gallery.destroy')->middleware('permission:delete_art_gallery');

            /* Art Book */
            Route::get('/art-book', [ArtBookController::class, 'index'])->name('art_book')->middleware('permission:view_art_book');
            Route::get('/art-book/generate', [ArtBookController::class, 'generate'])->name('art_book.generate')->middleware('permission:create_art_book');
            Route::get('/art-book/setup', [ArtBookController::class, 'setup'])->name('art_book.setup')->middleware('permission:create_art_book');
            Route::get('/art-book/get-lessons/{themeId}', [ArtBookController::class, 'getLessons'])->name('art_book.get_lessons')->middleware('permission:view_art_book');
            Route::get('/art-book/get-activities/{lessonId}', [ArtBookController::class, 'getActivities'])->name('art_book.get_activities')->middleware('permission:view_art_book');
            Route::post('/art-book/store-condition', [ArtBookController::class, 'storeCondition'])->name('art_book.store_condition')->middleware('permission:create_art_book');
            Route::post('/art-book/update-condition', [ArtBookController::class, 'updateCondition'])->name('art_book.update_condition')->middleware('permission:create_art_book');
            Route::delete('/art-book/delete-condition/{id}', [ArtBookController::class, 'deleteCondition'])->name('art_book.delete_condition')->middleware('permission:create_art_book');

            /* Stories */
            Route::middleware('permission:story_access')->group(function () {
                Route::get('/stories', [StoryController::class, 'index'])->name('stories')->middleware('permission:view_stories');
                Route::get('/stories/create', [StoryController::class, 'create'])->name('stories.create')->middleware('permission:create_stories');
                Route::post('/stories/store', [StoryHelper::class, 'createPost'])->name('stories.store')->middleware('permission:create_stories');
                Route::post('/stories/update', [StoryHelper::class, 'editPost'])->name('stories.update')->middleware('permission:edit_stories');
                Route::delete('/stories/destroy/{id}', [StoryHelper::class, 'deletePost'])->name('stories.destroy')->middleware('permission:delete_stories');
                Route::get('/stories/get-class-levels/{programme_id}/{class_type_id}', [ClassHelper::class, 'getClassLevels'])->name('stories.get_class_levels');
            });

            /* Assessments */
            Route::middleware('permission:assessment_access')->group(function () {
                Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments')->middleware('permission:view_assessments');
                Route::get('/assessments/create/{id}', [AssessmentController::class, 'create'])->name('assessments.create')->middleware('permission:create_assessments');
                Route::post('/assessments/store', [AssessmentController::class, 'store'])->name('assessments.store')->middleware('permission:create_assessments');
            });

            /* Setting */
            /* Level, Theme, Lesson, Activity List */
            // Route::get('/art-gallery/setting/levels', [ArtGalleryController::class, 'levels'])->name('art_gallery.setting.levels')->middleware('permission:view_art_gallery');
            // Route::get('/art-gallery/setting/themes', [ArtGalleryController::class, 'themes'])->name('art_gallery.setting.themes')->middleware('permission:view_art_gallery');
            // Route::get('/art-gallery/setting/lessons', [ArtGalleryController::class, 'lessons'])->name('art_gallery.setting.lessons')->middleware('permission:view_art_gallery');
            // Route::get('/art-gallery/setting/activities', [ArtGalleryController::class, 'activities'])->name('art_gallery.setting.activities')->middleware('permission:view_art_gallery');
            
            /* Level, Theme, Lesson, Activity Store */
            // Route::post('/art-gallery/setting/levels/store', [ArtGalleryController::class, 'levelStore'])->name('art_gallery.setting.levels.store')->middleware('permission:view_art_gallery');
            // Route::post('/art-gallery/setting/themes/store', [ArtGalleryController::class, 'themeStore'])->name('art_gallery.setting.themes.store')->middleware('permission:view_art_gallery');
            // Route::post('/art-gallery/setting/lessons/store', [ArtGalleryController::class, 'lessonStore'])->name('art_gallery.setting.lessons.store')->middleware('permission:view_art_gallery');
            // Route::post('/art-gallery/setting/activities/store', [ArtGalleryController::class, 'activityStore'])->name('art_gallery.setting.activities.store')->middleware('permission:view_art_gallery');

            /* Level, Theme, Lesson, Activity Update */
            // Route::post('/art-gallery/setting/levels/update', [ArtGalleryController::class, 'levelUpdate'])->name('art_gallery.setting.levels.update')->middleware('permission:view_art_gallery');
            // Route::post('/art-gallery/setting/themes/update', [ArtGalleryController::class, 'themeUpdate'])->name('art_gallery.setting.themes.update')->middleware('permission:view_art_gallery');
            // Route::post('/art-gallery/setting/lessons/update', [ArtGalleryController::class, 'lessonUpdate'])->name('art_gallery.setting.lessons.update')->middleware('permission:view_art_gallery');
            // Route::post('/art-gallery/setting/activities/update', [ArtGalleryController::class, 'activityUpdate'])->name('art_gallery.setting.activities.update')->middleware('permission:view_art_gallery');

            /* Level, Theme, Lesson, Activity Delete */
            // Route::delete('/art-gallery/setting/levels/delete/{id}', [ArtGalleryController::class, 'levelDelete'])->name('art_gallery.setting.levels.delete')->middleware('permission:view_art_gallery');
            // Route::delete('/art-gallery/setting/themes/delete/{id}', [ArtGalleryController::class, 'themeDelete'])->name('art_gallery.setting.themes.delete')->middleware('permission:view_art_gallery');
            // Route::delete('/art-gallery/setting/lessons/delete/{id}', [ArtGalleryController::class, 'lessonDelete'])->name('art_gallery.setting.lessons.delete')->middleware('permission:view_art_gallery');
            // Route::delete('/art-gallery/setting/activities/delete/{id}', [ArtGalleryController::class, 'activityDelete'])->name('art_gallery.setting.activities.delete')->middleware('permission:view_art_gallery');

            /* Progress Report */
            Route::get('/progress-report', [ProgressReportController::class, 'index'])->name('progress_report')->middleware('permission:view_progress_report');
            Route::get('/progress-report/details', [ProgressReportController::class, 'details'])->name('progress_report.details')->middleware('permission:view_progress_report');
            Route::get('/progress-report/artworks', [ProgressReportController::class, 'artworks'])->name('progress_report.artworks')->middleware('permission:view_progress_report');
            Route::get('/progress-report/full-reports', [ProgressReportController::class, 'getFullProgressReports'])->name('progress_report.full_reports')->withoutMiddleware(['permission:student_access']);
            Route::post('/progress-report/store', [ProgressReportController::class, 'store'])->name('progress_report.store')->middleware('permission:view_progress_report');
            Route::post('/progress-report/summary/store', [ProgressReportController::class, 'storeSummary'])->name('progress_report.store_summary')->middleware('permission:view_progress_report');
            Route::post('/progress-report/generate-qr', [QRcodeGenerateController::class, 'generateQr'])->name('progress_report.generate_qr')->middleware('permission:view_progress_report');
            
            /* Progress Report Settings */
            Route::prefix('progress-report/settings')->middleware('permission:view_progress_report_settings')->group(function () {
                Route::get('/', [ProgressReportController::class, 'settings'])->name('progress_report.settings');
                
                /* Math*/
                Route::prefix('math')->group(function () {
                    Route::get('levels', [MathSettingController::class, 'mathLevels'])->name('progress_report.settings.math.levels')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/store', [MathSettingController::class, 'mathLevelsStore'])->name('progress_report.settings.math.levels.store')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/update', [MathSettingController::class, 'mathLevelsUpdate'])->name('progress_report.settings.math.levels.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('levels/destroy/{id}', [MathSettingController::class, 'mathLevelsDestroy'])->name('progress_report.settings.math.levels.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('terms-books', [MathSettingController::class, 'mathTermsBooks'])->name('progress_report.settings.math.terms_books')->middleware('permission:view_progress_report_settings');
                    Route::post('terms-books/store', [MathSettingController::class, 'mathTermsBooksStore'])->name('progress_report.settings.math.terms_books.store')->middleware('permission:view_progress_report_settings');
                    Route::post('terms-books/update', [MathSettingController::class, 'mathTermsBooksUpdate'])->name('progress_report.settings.math.terms_books.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('terms-books/destroy/{id}', [MathSettingController::class, 'mathTermsBooksDestroy'])->name('progress_report.settings.math.terms_books.destroy')->middleware('permission:view_progress_report_settings');
            
                    Route::get('units', [MathSettingController::class, 'mathUnits'])->name('progress_report.settings.math.units')->middleware('permission:view_progress_report_settings');
                    Route::post('units/store', [MathSettingController::class, 'mathUnitsStore'])->name('progress_report.settings.math.units.store')->middleware('permission:view_progress_report_settings');
                    Route::post('units/update', [MathSettingController::class, 'mathUnitsUpdate'])->name('progress_report.settings.math.units.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('units/destroy/{id}', [MathSettingController::class, 'mathUnitsDestroy'])->name('progress_report.settings.math.units.destroy')->middleware('permission:view_progress_report_settings');
            
                    Route::get('lessons', [MathSettingController::class, 'mathLessons'])->name('progress_report.settings.math.lessons')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/store', [MathSettingController::class, 'mathLessonsStore'])->name('progress_report.settings.math.lessons.store')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/update', [MathSettingController::class, 'mathLessonsUpdate'])->name('progress_report.settings.math.lessons.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('lessons/destroy/{id}', [MathSettingController::class, 'mathLessonsDestroy'])->name('progress_report.settings.math.lessons.destroy')->middleware('permission:view_progress_report_settings');

                    Route::get('objectives', [MathSettingController::class, 'mathObjectives'])->name('progress_report.settings.math.objectives')->middleware('permission:view_progress_report_settings');
                    Route::post('objectives/store', [MathSettingController::class, 'mathObjectivesStore'])->name('progress_report.settings.math.objectives.store')->middleware('permission:view_progress_report_settings');
                    Route::post('objectives/update', [MathSettingController::class, 'mathObjectivesUpdate'])->name('progress_report.settings.math.objectives.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('objectives/destroy/{id}', [MathSettingController::class, 'mathObjectivesDestroy'])->name('progress_report.settings.math.objectives.destroy')->middleware('permission:view_progress_report_settings');
                });

                /* Coding Robotics */
                Route::prefix('coding-robotics')->group(function () {
                    Route::get('levels', [CodingRoboticSettingController::class, 'codingRoboticsLevels'])->name('progress_report.settings.coding_robotics.levels')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/store', [CodingRoboticSettingController::class, 'codingRoboticsLevelsStore'])->name('progress_report.settings.coding_robotics.levels.store')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/update', [CodingRoboticSettingController::class, 'codingRoboticsLevelsUpdate'])->name('progress_report.settings.coding_robotics.levels.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('levels/destroy/{id}', [CodingRoboticSettingController::class, 'codingRoboticsLevelsDestroy'])->name('progress_report.settings.coding_robotics.levels.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('lessons', [CodingRoboticSettingController::class, 'codingRoboticsLessons'])->name('progress_report.settings.coding_robotics.lessons')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/store', [CodingRoboticSettingController::class, 'codingRoboticsLessonsStore'])->name('progress_report.settings.coding_robotics.lessons.store')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/update', [CodingRoboticSettingController::class, 'codingRoboticsLessonsUpdate'])->name('progress_report.settings.coding_robotics.lessons.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('lessons/destroy/{id}', [CodingRoboticSettingController::class, 'codingRoboticsLessonsDestroy'])->name('progress_report.settings.coding_robotics.lessons.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('topics', [CodingRoboticSettingController::class, 'codingRoboticsTopics'])->name('progress_report.settings.coding_robotics.topics')->middleware('permission:view_progress_report_settings');
                    Route::post('topics/store', [CodingRoboticSettingController::class, 'codingRoboticsTopicsStore'])->name('progress_report.settings.coding_robotics.topics.store')->middleware('permission:view_progress_report_settings');
                    Route::post('topics/update', [CodingRoboticSettingController::class, 'codingRoboticsTopicsUpdate'])->name('progress_report.settings.coding_robotics.topics.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('topics/destroy/{id}', [CodingRoboticSettingController::class, 'codingRoboticsTopicsDestroy'])->name('progress_report.settings.coding_robotics.topics.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('objectives', [CodingRoboticSettingController::class, 'codingRoboticsObjectives'])->name('progress_report.settings.coding_robotics.objectives')->middleware('permission:view_progress_report_settings');
                    Route::post('objectives/store', [CodingRoboticSettingController::class, 'codingRoboticsObjectivesStore'])->name('progress_report.settings.coding_robotics.objectives.store')->middleware('permission:view_progress_report_settings');
                    Route::post('objectives/update', [CodingRoboticSettingController::class, 'codingRoboticsObjectivesUpdate'])->name('progress_report.settings.coding_robotics.objectives.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('objectives/destroy/{id}', [CodingRoboticSettingController::class, 'codingRoboticsObjectivesDestroy'])->name('progress_report.settings.coding_robotics.objectives.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('activities-procedures', [CodingRoboticSettingController::class, 'codingRoboticsActivitiesProcedures'])->name('progress_report.settings.coding_robotics.activities_procedures')->middleware('permission:view_progress_report_settings');
                    Route::post('activities-procedures/store', [CodingRoboticSettingController::class, 'codingRoboticsActivitiesProceduresStore'])->name('progress_report.settings.coding_robotics.activities_procedures.store')->middleware('permission:view_progress_report_settings');
                    Route::post('activities-procedures/update', [CodingRoboticSettingController::class, 'codingRoboticsActivitiesProceduresUpdate'])->name('progress_report.settings.coding_robotics.activities_procedures.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('activities-procedures/destroy/{id}', [CodingRoboticSettingController::class, 'codingRoboticsActivitiesProceduresDestroy'])->name('progress_report.settings.coding_robotics.activities_procedures.destroy')->middleware('permission:view_progress_report_settings');
                });
                
                /* Digital Art */
                Route::prefix('digital-art')->group(function () {
                    Route::get('levels', [DigitalArtSettingController::class, 'digitalArtLevels'])->name('progress_report.settings.digital_art.levels')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/store', [DigitalArtSettingController::class, 'digitalArtLevelsStore'])->name('progress_report.settings.digital_art.levels.store')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/update', [DigitalArtSettingController::class, 'digitalArtLevelsUpdate'])->name('progress_report.settings.digital_art.levels.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('levels/destroy/{id}', [DigitalArtSettingController::class, 'digitalArtLevelsDestroy'])->name('progress_report.settings.digital_art.levels.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('themes', [DigitalArtSettingController::class, 'digitalArtThemes'])->name('progress_report.settings.digital_art.themes')->middleware('permission:view_progress_report_settings');
                    Route::post('themes/store', [DigitalArtSettingController::class, 'digitalArtThemesStore'])->name('progress_report.settings.digital_art.themes.store')->middleware('permission:view_progress_report_settings');
                    Route::post('themes/update', [DigitalArtSettingController::class, 'digitalArtThemesUpdate'])->name('progress_report.settings.digital_art.themes.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('themes/destroy/{id}', [DigitalArtSettingController::class, 'digitalArtThemesDestroy'])->name('progress_report.settings.digital_art.themes.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('lessons', [DigitalArtSettingController::class, 'digitalArtLessons'])->name('progress_report.settings.digital_art.lessons')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/store', [DigitalArtSettingController::class, 'digitalArtLessonsStore'])->name('progress_report.settings.digital_art.lessons.store')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/update', [DigitalArtSettingController::class, 'digitalArtLessonsUpdate'])->name('progress_report.settings.digital_art.lessons.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('lessons/destroy/{id}', [DigitalArtSettingController::class, 'digitalArtLessonsDestroy'])->name('progress_report.settings.digital_art.lessons.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('activities', [DigitalArtSettingController::class, 'digitalArtActivities'])->name('progress_report.settings.digital_art.activities')->middleware('permission:view_progress_report_settings');
                    Route::post('activities/store', [DigitalArtSettingController::class, 'digitalArtActivitiesStore'])->name('progress_report.settings.digital_art.activities.store')->middleware('permission:view_progress_report_settings');
                    Route::post('activities/update', [DigitalArtSettingController::class, 'digitalArtActivitiesUpdate'])->name('progress_report.settings.digital_art.activities.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('activities/destroy/{id}', [DigitalArtSettingController::class, 'digitalArtActivitiesDestroy'])->name('progress_report.settings.digital_art.activities.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('outcomes', [DigitalArtSettingController::class, 'digitalArtOutcomes'])->name('progress_report.settings.digital_art.outcomes')->middleware('permission:view_progress_report_settings');
                    Route::post('outcomes/store', [DigitalArtSettingController::class, 'digitalArtOutcomesStore'])->name('progress_report.settings.digital_art.outcomes.store')->middleware('permission:view_progress_report_settings');
                    Route::post('outcomes/update', [DigitalArtSettingController::class, 'digitalArtOutcomesUpdate'])->name('progress_report.settings.digital_art.outcomes.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('outcomes/destroy/{id}', [DigitalArtSettingController::class, 'digitalArtOutcomesDestroy'])->name('progress_report.settings.digital_art.outcomes.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('objectives', [DigitalArtSettingController::class, 'digitalArtObjectives'])->name('progress_report.settings.digital_art.objectives')->middleware('permission:view_progress_report_settings');
                    Route::post('objectives/store', [DigitalArtSettingController::class, 'digitalArtObjectivesStore'])->name('progress_report.settings.digital_art.objectives.store')->middleware('permission:view_progress_report_settings');
                    Route::post('objectives/update', [DigitalArtSettingController::class, 'digitalArtObjectivesUpdate'])->name('progress_report.settings.digital_art.objectives.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('objectives/destroy/{id}', [DigitalArtSettingController::class, 'digitalArtObjectivesDestroy'])->name('progress_report.settings.digital_art.objectives.destroy')->middleware('permission:view_progress_report_settings');
                });
            
                /* Little Bot */
                Route::prefix('little-bot')->group(function () {
                    Route::get('levels', [LittleBotSettingController::class, 'littleBotLevels'])->name('progress_report.settings.little_bot.levels')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/store', [LittleBotSettingController::class, 'littleBotLevelsStore'])->name('progress_report.settings.little_bot.levels.store')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/update', [LittleBotSettingController::class, 'littleBotLevelsUpdate'])->name('progress_report.settings.little_bot.levels.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('levels/destroy/{id}', [LittleBotSettingController::class, 'littleBotLevelsDestroy'])->name('progress_report.settings.little_bot.levels.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('lessons', [LittleBotSettingController::class, 'littleBotLessons'])->name('progress_report.settings.little_bot.lessons')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/store', [LittleBotSettingController::class, 'littleBotLessonsStore'])->name('progress_report.settings.little_bot.lessons.store')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/update', [LittleBotSettingController::class, 'littleBotLessonsUpdate'])->name('progress_report.settings.little_bot.lessons.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('lessons/destroy/{id}', [LittleBotSettingController::class, 'littleBotLessonsDestroy'])->name('progress_report.settings.little_bot.lessons.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('topics', [LittleBotSettingController::class, 'littleBotTopics'])->name('progress_report.settings.little_bot.topics')->middleware('permission:view_progress_report_settings');
                    Route::post('topics/store', [LittleBotSettingController::class, 'littleBotTopicsStore'])->name('progress_report.settings.little_bot.topics.store')->middleware('permission:view_progress_report_settings');
                    Route::post('topics/update', [LittleBotSettingController::class, 'littleBotTopicsUpdate'])->name('progress_report.settings.little_bot.topics.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('topics/destroy/{id}', [LittleBotSettingController::class, 'littleBotTopicsDestroy'])->name('progress_report.settings.little_bot.topics.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('learning-objectives', [LittleBotSettingController::class, 'littleBotObjectives'])->name('progress_report.settings.little_bot.objectives')->middleware('permission:view_progress_report_settings');
                    Route::post('learning-objectives/store', [LittleBotSettingController::class, 'littleBotObjectivesStore'])->name('progress_report.settings.little_bot.objectives.store')->middleware('permission:view_progress_report_settings');
                    Route::post('learning-objectives/update', [LittleBotSettingController::class, 'littleBotObjectivesUpdate'])->name('progress_report.settings.little_bot.objectives.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('learning-objectives/destroy/{id}', [LittleBotSettingController::class, 'littleBotObjectivesDestroy'])->name('progress_report.settings.little_bot.objectives.destroy')->middleware('permission:view_progress_report_settings');
                });
            
                /* Little Artist */
                Route::prefix('little-artist')->group(function () {
                    Route::get('levels', [LittleArtistSettingController::class, 'littleArtistLevels'])->name('progress_report.settings.little_artist.levels')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/store', [LittleArtistSettingController::class, 'littleArtistLevelsStore'])->name('progress_report.settings.little_artist.levels.store')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/update', [LittleArtistSettingController::class, 'littleArtistLevelsUpdate'])->name('progress_report.settings.little_artist.levels.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('levels/destroy/{id}', [LittleArtistSettingController::class, 'littleArtistLevelsDestroy'])->name('progress_report.settings.little_artist.levels.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('lessons', [LittleArtistSettingController::class, 'littleArtistLessons'])->name('progress_report.settings.little_artist.lessons')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/store', [LittleArtistSettingController::class, 'littleArtistLessonsStore'])->name('progress_report.settings.little_artist.lessons.store')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/update', [LittleArtistSettingController::class, 'littleArtistLessonsUpdate'])->name('progress_report.settings.little_artist.lessons.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('lessons/destroy/{id}', [LittleArtistSettingController::class, 'littleArtistLessonsDestroy'])->name('progress_report.settings.little_artist.lessons.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('outcomes', [LittleArtistSettingController::class, 'littleArtistOutcomes'])->name('progress_report.settings.little_artist.outcomes')->middleware('permission:view_progress_report_settings');
                    Route::post('outcomes/store', [LittleArtistSettingController::class, 'littleArtistOutcomesStore'])->name('progress_report.settings.little_artist.outcomes.store')->middleware('permission:view_progress_report_settings');
                    Route::post('outcomes/update', [LittleArtistSettingController::class, 'littleArtistOutcomesUpdate'])->name('progress_report.settings.little_artist.outcomes.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('outcomes/destroy/{id}', [LittleArtistSettingController::class, 'littleArtistOutcomesDestroy'])->name('progress_report.settings.little_artist.outcomes.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('learning-objectives', [LittleArtistSettingController::class, 'littleArtistObjectives'])->name('progress_report.settings.little_artist.objectives')->middleware('permission:view_progress_report_settings');
                    Route::post('learning-objectives/store', [LittleArtistSettingController::class, 'littleArtistObjectivesStore'])->name('progress_report.settings.little_artist.objectives.store')->middleware('permission:view_progress_report_settings');
                    Route::post('learning-objectives/update', [LittleArtistSettingController::class, 'littleArtistObjectivesUpdate'])->name('progress_report.settings.little_artist.objectives.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('learning-objectives/destroy/{id}', [LittleArtistSettingController::class, 'littleArtistObjectivesDestroy'])->name('progress_report.settings.little_artist.objectives.destroy')->middleware('permission:view_progress_report_settings');
                });
                
                /* Art Digital */
                Route::prefix('art-digital')->group(function () {
                    Route::get('levels', [ArtDigitalSettingController::class, 'artDigitalLevels'])->name('progress_report.settings.art_digital.levels')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/store', [ArtDigitalSettingController::class, 'artDigitalLevelsStore'])->name('progress_report.settings.art_digital.levels.store')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/update', [ArtDigitalSettingController::class, 'artDigitalLevelsUpdate'])->name('progress_report.settings.art_digital.levels.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('levels/destroy/{id}', [ArtDigitalSettingController::class, 'artDigitalLevelsDestroy'])->name('progress_report.settings.art_digital.levels.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('themes', [ArtDigitalSettingController::class, 'artDigitalThemes'])->name('progress_report.settings.art_digital.themes')->middleware('permission:view_progress_report_settings');
                    Route::post('themes/store', [ArtDigitalSettingController::class, 'artDigitalThemesStore'])->name('progress_report.settings.art_digital.themes.store')->middleware('permission:view_progress_report_settings');
                    Route::post('themes/update', [ArtDigitalSettingController::class, 'artDigitalThemesUpdate'])->name('progress_report.settings.art_digital.themes.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('themes/destroy/{id}', [ArtDigitalSettingController::class, 'artDigitalThemesDestroy'])->name('progress_report.settings.art_digital.themes.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('lessons', [ArtDigitalSettingController::class, 'artDigitalLessons'])->name('progress_report.settings.art_digital.lessons')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/store', [ArtDigitalSettingController::class, 'artDigitalLessonsStore'])->name('progress_report.settings.art_digital.lessons.store')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/update', [ArtDigitalSettingController::class, 'artDigitalLessonsUpdate'])->name('progress_report.settings.art_digital.lessons.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('lessons/destroy/{id}', [ArtDigitalSettingController::class, 'artDigitalLessonsDestroy'])->name('progress_report.settings.art_digital.lessons.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('activities', [ArtDigitalSettingController::class, 'artDigitalActivities'])->name('progress_report.settings.art_digital.activities')->middleware('permission:view_progress_report_settings');
                    Route::post('activities/store', [ArtDigitalSettingController::class, 'artDigitalActivitiesStore'])->name('progress_report.settings.art_digital.activities.store')->middleware('permission:view_progress_report_settings');
                    Route::post('activities/update', [ArtDigitalSettingController::class, 'artDigitalActivitiesUpdate'])->name('progress_report.settings.art_digital.activities.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('activities/destroy/{id}', [ArtDigitalSettingController::class, 'artDigitalActivitiesDestroy'])->name('progress_report.settings.art_digital.activities.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('outcomes', [ArtDigitalSettingController::class, 'artDigitalOutcomes'])->name('progress_report.settings.art_digital.outcomes')->middleware('permission:view_progress_report_settings');
                    Route::post('outcomes/store', [ArtDigitalSettingController::class, 'artDigitalOutcomesStore'])->name('progress_report.settings.art_digital.outcomes.store')->middleware('permission:view_progress_report_settings');
                    Route::post('outcomes/update', [ArtDigitalSettingController::class, 'artDigitalOutcomesUpdate'])->name('progress_report.settings.art_digital.outcomes.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('outcomes/destroy/{id}', [ArtDigitalSettingController::class, 'artDigitalOutcomesDestroy'])->name('progress_report.settings.art_digital.outcomes.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('objectives', [ArtDigitalSettingController::class, 'artDigitalObjectives'])->name('progress_report.settings.art_digital.objectives')->middleware('permission:view_progress_report_settings');
                    Route::post('objectives/store', [ArtDigitalSettingController::class, 'artDigitalObjectivesStore'])->name('progress_report.settings.art_digital.objectives.store')->middleware('permission:view_progress_report_settings');
                    Route::post('objectives/update', [ArtDigitalSettingController::class, 'artDigitalObjectivesUpdate'])->name('progress_report.settings.art_digital.objectives.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('objectives/destroy/{id}', [ArtDigitalSettingController::class, 'artDigitalObjectivesDestroy'])->name('progress_report.settings.art_digital.objectives.destroy')->middleware('permission:view_progress_report_settings');
                });
                
                /* Art Traditional */
                Route::prefix('art-traditional')->group(function () {
                    Route::get('levels', [ArtTraditionalSettingController::class, 'artTraditionalLevels'])->name('progress_report.settings.art_traditional.levels')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/store', [ArtTraditionalSettingController::class, 'artTraditionalLevelsStore'])->name('progress_report.settings.art_traditional.levels.store')->middleware('permission:view_progress_report_settings');
                    Route::post('levels/update', [ArtTraditionalSettingController::class, 'artTraditionalLevelsUpdate'])->name('progress_report.settings.art_traditional.levels.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('levels/destroy/{id}', [ArtTraditionalSettingController::class, 'artTraditionalLevelsDestroy'])->name('progress_report.settings.art_traditional.levels.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('themes', [ArtTraditionalSettingController::class, 'artTraditionalThemes'])->name('progress_report.settings.art_traditional.themes')->middleware('permission:view_progress_report_settings');
                    Route::post('themes/store', [ArtTraditionalSettingController::class, 'artTraditionalThemesStore'])->name('progress_report.settings.art_traditional.themes.store')->middleware('permission:view_progress_report_settings');
                    Route::post('themes/update', [ArtTraditionalSettingController::class, 'artTraditionalThemesUpdate'])->name('progress_report.settings.art_traditional.themes.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('themes/destroy/{id}', [ArtTraditionalSettingController::class, 'artTraditionalThemesDestroy'])->name('progress_report.settings.art_traditional.themes.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('lessons', [ArtTraditionalSettingController::class, 'artTraditionalLessons'])->name('progress_report.settings.art_traditional.lessons')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/store', [ArtTraditionalSettingController::class, 'artTraditionalLessonsStore'])->name('progress_report.settings.art_traditional.lessons.store')->middleware('permission:view_progress_report_settings');
                    Route::post('lessons/update', [ArtTraditionalSettingController::class, 'artTraditionalLessonsUpdate'])->name('progress_report.settings.art_traditional.lessons.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('lessons/destroy/{id}', [ArtTraditionalSettingController::class, 'artTraditionalLessonsDestroy'])->name('progress_report.settings.art_traditional.lessons.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('activities', [ArtTraditionalSettingController::class, 'artTraditionalActivities'])->name('progress_report.settings.art_traditional.activities')->middleware('permission:view_progress_report_settings');
                    Route::post('activities/store', [ArtTraditionalSettingController::class, 'artTraditionalActivitiesStore'])->name('progress_report.settings.art_traditional.activities.store')->middleware('permission:view_progress_report_settings');
                    Route::post('activities/update', [ArtTraditionalSettingController::class, 'artTraditionalActivitiesUpdate'])->name('progress_report.settings.art_traditional.activities.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('activities/destroy/{id}', [ArtTraditionalSettingController::class, 'artTraditionalActivitiesDestroy'])->name('progress_report.settings.art_traditional.activities.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('outcomes', [ArtTraditionalSettingController::class, 'artTraditionalOutcomes'])->name('progress_report.settings.art_traditional.outcomes')->middleware('permission:view_progress_report_settings');
                    Route::post('outcomes/store', [ArtTraditionalSettingController::class, 'artTraditionalOutcomesStore'])->name('progress_report.settings.art_traditional.outcomes.store')->middleware('permission:view_progress_report_settings');
                    Route::post('outcomes/update', [ArtTraditionalSettingController::class, 'artTraditionalOutcomesUpdate'])->name('progress_report.settings.art_traditional.outcomes.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('outcomes/destroy/{id}', [ArtTraditionalSettingController::class, 'artTraditionalOutcomesDestroy'])->name('progress_report.settings.art_traditional.outcomes.destroy')->middleware('permission:view_progress_report_settings');
                    
                    Route::get('objectives', [ArtTraditionalSettingController::class, 'artTraditionalObjectives'])->name('progress_report.settings.art_traditional.objectives')->middleware('permission:view_progress_report_settings');
                    Route::post('objectives/store', [ArtTraditionalSettingController::class, 'artTraditionalObjectivesStore'])->name('progress_report.settings.art_traditional.objectives.store')->middleware('permission:view_progress_report_settings');
                    Route::post('objectives/update', [ArtTraditionalSettingController::class, 'artTraditionalObjectivesUpdate'])->name('progress_report.settings.art_traditional.objectives.update')->middleware('permission:view_progress_report_settings');
                    Route::delete('objectives/destroy/{id}', [ArtTraditionalSettingController::class, 'artTraditionalObjectivesDestroy'])->name('progress_report.settings.art_traditional.objectives.destroy')->middleware('permission:view_progress_report_settings');
                });
            });
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
        Route::prefix('diagnostic-test/settings')->middleware('permission:diagnostic_test_access')->group(function () {
            /* Diagnostic Test List */
            Route::get('/', [DiagnosticTestController::class, 'dtList'])->name('dt.settings');
            Route::get('/create', [DiagnosticTestController::class, 'dtCreate'])->name('dt.settings.create');
            Route::post('/store', [DiagnosticTestController::class, 'dtStore'])->name('dt.settings.store');
            Route::get('/edit', [DiagnosticTestController::class, 'dtEdit'])->name('dt.settings.edit');
            Route::post('/update', [DiagnosticTestController::class, 'dtUpdate'])->name('dt.settings.update');
            Route::delete('/destroy/{id}', [DiagnosticTestController::class, 'dtDestroy'])->name('dt.settings.destroy');

            /* Diagnostic Test Detail List */
            Route::get('/details', [DiagnosticTestController::class, 'dtDetailsList'])->name('dt.settings.details');
            Route::get('/details/create', [DiagnosticTestController::class, 'dtDetailsCreate'])->name('dt.settings.details.create');
            Route::post('/details/store', [DiagnosticTestController::class, 'dtDetailsStore'])->name('dt.settings.details.store');
            Route::get('/details/edit', [DiagnosticTestController::class, 'dtDetailsEdit'])->name('dt.settings.details.edit');
            Route::post('/details/update', [DiagnosticTestController::class, 'dtDetailsUpdate'])->name('dt.settings.details.update');
            Route::delete('/details/destroy/{id}', [DiagnosticTestController::class, 'dtDetailsDestroy'])->name('dt.settings.details.destroy');
            Route::post('/details/sort', [DiagnosticTestController::class, 'dtDetailsSort'])->name('dt.settings.details.sort');

            /* Diagnostic Test Detail Conditions */
            Route::get('/conditions/create', [DiagnosticTestController::class, 'dtConditionsCreate'])->name('dt.settings.conditions.create');
            Route::post('/conditions/store', [DiagnosticTestController::class, 'dtConditionsStore'])->name('dt.settings.conditions.store');
            Route::get('/conditions/edit', [DiagnosticTestController::class, 'dtConditionsEdit'])->name('dt.settings.conditions.edit');
            Route::post('/conditions/update', [DiagnosticTestController::class, 'dtConditionsUpdate'])->name('dt.settings.conditions.update');
            Route::delete('/conditions/destroy/{id}', [DiagnosticTestController::class, 'dtConditionsDestroy'])->name('dt.settings.conditions.destroy');

            /* Diagnostic Test Detail Categories */
            Route::get('/categories/create', [DiagnosticTestController::class, 'dtCategoriesCreate'])->name('dt.settings.categories.create');
            Route::post('/categories/store', [DiagnosticTestController::class, 'dtCategoriesStore'])->name('dt.settings.categories.store');
            Route::get('/categories/edit', [DiagnosticTestController::class, 'dtCategoriesEdit'])->name('dt.settings.categories.edit');
            Route::post('/categories/update', [DiagnosticTestController::class, 'dtCategoriesUpdate'])->name('dt.settings.categories.update');
            Route::delete('/categories/destroy/{id}', [DiagnosticTestController::class, 'dtCategoriesDestroy'])->name('dt.settings.categories.destroy');

            /* Diagnostic Test Languages */
            Route::get('/languages', [DiagnosticTestController::class, 'dtLanguages'])->name('dt.settings.languages');
            Route::post('/languages/store', [DiagnosticTestController::class, 'dtLanguagesStore'])->name('dt.settings.languages.store');
            Route::get('/languages/edit', [DiagnosticTestController::class, 'dtLanguagesEdit'])->name('dt.settings.languages.edit');
            Route::post('/languages/update', [DiagnosticTestController::class, 'dtLanguagesUpdate'])->name('dt.settings.languages.update');
            Route::delete('/languages/destroy/{id}', [DiagnosticTestController::class, 'dtLanguagesDestroy'])->name('dt.settings.languages.destroy');
        });

        /* Accounting */
        Route::prefix('accounting')->middleware('permission:accounting_access')->group(function () {
            Route::get('/fee-invoices', [InvoiceController::class, 'feeInvoiceIndex'])->name('fee.invoices')->middleware('permission:view_fee_invoices');
            Route::get('/fee-invoices/create', [InvoiceController::class, 'feeInvoiceCreate'])->name('fee.invoices.create')->middleware('permission:create_fee_invoices');
            Route::post('/fee-invoices/store', [InvoiceController::class, 'feeInvoiceStore'])->name('fee.invoices.store')->middleware('permission:create_fee_invoices');
            Route::get('/fee-invoices/edit', [InvoiceController::class, 'feeInvoiceEdit'])->name('fee.invoices.edit')->middleware('permission:edit_fee_invoices');
            Route::post('/fee-invoices/update', [InvoiceController::class, 'feeInvoiceUpdate'])->name('fee.invoices.update')->middleware('permission:edit_fee_invoices');
            Route::delete('/fee-invoices/destroy/{id}', [InvoiceController::class, 'feeInvoiceDestroy'])->name('fee.invoices.destroy')->middleware('permission:delete_fee_invoices');

            
            Route::get('/promos', [PromoController::class, 'index'])->name('fee.promos')->middleware('permission:view_promos');
            Route::get('/promos/create', [PromoController::class, 'create'])->name('fee.promos.create')->middleware('permission:create_promos');
            Route::post('/promos/store', [PromoController::class, 'store'])->name('fee.promos.store')->middleware('permission:create_promos');
            // Route::get('/promos/edit', [PromoController::class, 'feeInvoiceEdit'])->name('fee.invoices.edit')->middleware('permission:edit_promos');
            // Route::post('/promos/update', [PromoController::class, 'feeInvoiceUpdate'])->name('fee.invoices.update')->middleware('permission:edit_promos');
            Route::delete('/promos/destroy/{id}', [PromoController::class, 'destroy'])->name('fee.promos.destroy')->middleware('permission:delete_promos');
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
        Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
        Route::post('/profile/security/store', [ProfileController::class, 'storeSecurity'])->name('profile.security.store');

        /* Children */
        Route::post('/children/store', [ChildrenController::class, 'store'])->name('children.store');
        Route::get('/children/edit', [ChildrenController::class, 'edit'])->name('children.edit');
        Route::post('/children/update', [ChildrenController::class, 'update'])->name('children.update');
        Route::delete('/children/delete/{id}', [ChildrenController::class, 'destroy'])->name('children.destroy');

        /* Notifications */
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::get('/notifications/view', [NotificationController::class, 'viewNotification'])->name('view_notification');
        Route::get('/notifications/show-more', [NotificationController::class, 'showMoreNotifications'])->name('show_more_notifications');
        Route::delete('/notifications/delete', [NotificationController::class, 'deleteNotification'])->name('delete_notification');

        /* Temporary Disabled */
        // Route::get('/settings/class_types', [SettingController::class, 'classTypeList'])->name('settings.class_types');
        // Route::get('/settings/class_types/create', [SettingController::class, 'addClassType'])->name('settings.class_types.create');
        // Route::post('/settings/class_types/store', [SettingController::class, 'storeClassType'])->name('settings.class_types.store');
        // Route::get('/settings/class_types/edit', [SettingController::class, 'editClassType'])->name('settings.class_types.edit');
        // Route::post('/settings/class_types/update', [SettingController::class, 'updateClassType'])->name('settings.class_types.update');
        // Route::delete('/settings/class_types/destroy/{id}', [SettingController::class, 'destroyClassType'])->name('settings.class_types.destroy');
    });
});
