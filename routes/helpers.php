<?php

use App\Classes\ProgrammeHelper;
use App\Classes\StudentHelper;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Parent\ArtGalleryController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProgressReportController;
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

    /* Childrens */
    Route::prefix('children')->group(function () {
        Route::get('find', [ChildrenController::class, 'findChildren'])->name('children.find');
    });

    /* Students */
    Route::prefix('students')->group(function () {
        Route::get('find', [StudentController::class, 'findStudents'])->name('students.find');
        Route::get('find-digital-art-students', [StudentController::class, 'findDigitalArtStudents'])->name('students.find_digital_art_students');
        Route::get('fees/{id}', [StudentHelper::class, 'getStudentFees'])->name('students.fees');
    });

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

});