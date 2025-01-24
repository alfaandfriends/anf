<?php

use App\Classes\GeneralHelper;
use App\Classes\ParentHelper;
use App\Classes\ProgrammeHelper;
use App\Classes\StudentHelper;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ArtGalleryController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProgressReport\ProgressReportController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){

    /* Country */
    Route::get('countries', [CountryController::class, 'getCountries'])->name('countries.list');
    Route::get('countries/find/{id}', [CountryController::class, 'getCountry'])->name('countries.find');

    /* File Download */
    Route::get('teacher_resources/{filename}', [DownloadController::class, 'teacherResources'])->name('download.teacher_resources');

    /* Programmes */
    Route::prefix('programmes')->group(function () {
        Route::get('get-programme-levels/{programme_id}', [ProgrammeHelper::class, 'getProgrammeLevels'])->name('get_programme_levels');
    });

    /* Parents */
    Route::prefix('parents')->group(function () {
        Route::get('find', [ParentHelper::class, 'getParents'])->name('parents.find');
    });

    /* Childrens */
    Route::prefix('children')->group(function () {
        Route::get('find', [ChildrenController::class, 'findChildren'])->name('children.find');
    });

    /* Teachers */
    Route::prefix('teachers')->group(function () {
        Route::get('find', [GeneralHelper::class, 'findTeachers'])->name('teachers.find');
    });

    /* Students */
    Route::prefix('students')->group(function () {
        Route::get('find', [StudentController::class, 'findStudents'])->name('students.find');
        Route::get('find-digital-art-students', [StudentController::class, 'findDigitalArtStudents'])->name('students.find_digital_art_students');
        Route::get('fees/{id}', [StudentHelper::class, 'getStudentFees'])->name('students.fees');
    });

    /* Art Gallery Options */
    Route::get('/art-gallery/get_levels/{id}', [ArtGalleryController::class, 'getLevels'])->name('art_gallery.get_levels');
    Route::get('/art-gallery/get_themes/{id}', [ArtGalleryController::class, 'getThemes'])->name('art_gallery.get_themes');
    Route::get('/art-gallery/get_lessons/{id}', [ArtGalleryController::class, 'getLessons'])->name('art_gallery.get_lessons');
    Route::get('/art-gallery/get_activities/{id}', [ArtGalleryController::class, 'getActivities'])->name('art_gallery.get_activities');

    /* Math Select Options */
    Route::get('/progress-report/math/get-units/{term_book_id}', [ProgressReportController::class, 'getMathUnits'])->name('progress_report.get_math_units');
    Route::get('/progress-report/math/get-lessons/{unit_id}', [ProgressReportController::class, 'getMathLessons'])->name('progress_report.get_math_lessons');
    Route::get('/progress-report/math/get-objectives/{lesson_id}', [ProgressReportController::class, 'getMathObjectives'])->name('progress_report.get_math_objectives');
    
    /* Coding Select Options */
    Route::get('/progress-report/coding/get-topics/{lesson_id}', [ProgressReportController::class, 'getCodingTopics'])->name('progress_report.get_coding_topics');
    Route::get('/progress-report/coding/get-objectives/{topic_id}', [ProgressReportController::class, 'getCodingObjectives'])->name('progress_report.get_coding_objectives');
    Route::get('/progress-report/coding/get-activities-procedures/{objective_id}', [ProgressReportController::class, 'getCodingActivitiesProcedures'])->name('progress_report.get_coding_activities_procedures');
    
    /* Art Select Options */
    Route::get('/progress-report/art/get-lessons/{theme_id}', [ProgressReportController::class, 'getArtLessons'])->name('progress_report.get_art_lessons');
    Route::get('/progress-report/art/get-activities/{lesson_id}', [ProgressReportController::class, 'getArtActivities'])->name('progress_report.get_art_activities');
    Route::get('/progress-report/art/get-learning-outcomes/{activity_id}', [ProgressReportController::class, 'getArtLearningOutcomes'])->name('progress_report.get_art_learning_outcomes');
    Route::get('/progress-report/art/get-objectives/{outcome_id}', [ProgressReportController::class, 'getArtObjectives'])->name('progress_report.get_art_objectives');

    /* Little Bot Select Options */
    Route::get('/progress-report/little-bot/get-topics/{lesson_id}', [ProgressReportController::class, 'getLittleBotTopics'])->name('progress_report.get_little_bot_topics');
    Route::get('/progress-report/little-bot/get-objectives/{topic_id}', [ProgressReportController::class, 'getLittleBotObjectives'])->name('progress_report.get_little_bot_objectives');
    
    /* Little Artist Select Options */
    Route::get('/progress-report/little-artist/get-outcomes/{lesson_id}', [ProgressReportController::class, 'getLittleArtistOutcomes'])->name('progress_report.get_little_artist_outcomes');
    Route::get('/progress-report/little-artist/get-objectives/{outcome_id}', [ProgressReportController::class, 'getLittleArtistObjectives'])->name('progress_report.get_little_artist_objectives');

    /* Art Digital Select Options */
    Route::get('/progress-report/art-digital/get-lessons/{theme_id}', [ProgressReportController::class, 'getArtDigitalLessons'])->name('progress_report.get_art_digital_lessons');
    Route::get('/progress-report/art-digital/get-activities/{lesson_id}', [ProgressReportController::class, 'getArtDigitalActivities'])->name('progress_report.get_art_digital_activities');
    Route::get('/progress-report/art-digital/get-learning-outcomes/{activity_id}', [ProgressReportController::class, 'getArtDigitalLearningOutcomes'])->name('progress_report.get_art_digital_learning_outcomes');
    Route::get('/progress-report/art-digital/get-objectives/{outcome_id}', [ProgressReportController::class, 'getArtDigitalObjectives'])->name('progress_report.get_art_digital_objectives');

    /* Art Traditional Select Options */
    Route::get('/progress-report/art-traditional/get-lessons/{theme_id}', [ProgressReportController::class, 'getArtTraditionalLessons'])->name('progress_report.get_art_traditional_lessons');
    Route::get('/progress-report/art-traditional/get-activities/{lesson_id}', [ProgressReportController::class, 'getArtTraditionalActivities'])->name('progress_report.get_art_traditional_activities');
    Route::get('/progress-report/art-traditional/get-learning-outcomes/{activity_id}', [ProgressReportController::class, 'getArtTraditionalLearningOutcomes'])->name('progress_report.get_art_traditional_learning_outcomes');
    Route::get('/progress-report/art-traditional/get-objectives/{outcome_id}', [ProgressReportController::class, 'getArtTraditionalObjectives'])->name('progress_report.get_art_traditional_objectives');
});