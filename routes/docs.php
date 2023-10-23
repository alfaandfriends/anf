<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'device'])->group(function(){
    Route::prefix('admin')->group(function () {
        /* Documentation */
        Route::get('/docs/workflow', function () {
            return Inertia::render('Docs/Workflow');
        })->name('docs.workflow');

        Route::get('/docs/setup', function () {
            return Inertia::render('Docs/Setup');
        })->name('docs.setup');

        Route::get('/docs/art-gallery', function () {
            return Inertia::render('Docs/ArtGallery');
        })->name('docs.art_gallery');

        Route::get('/docs/centre-manager', function () {
            return Inertia::render('Docs/CentreManager');
        })->name('docs.centre_manager');

        Route::get('/docs/centres', function () {
            return Inertia::render('Docs/Centres');
        })->name('docs.centres');

        Route::get('/docs/classes', function () {
            return Inertia::render('Docs/Classes');
        })->name('docs.classes');

        Route::get('/docs/countries', function () {
            return Inertia::render('Docs/Countries');
        })->name('docs.countries');

        Route::get('/docs/diagnostic-test', function () {
            return Inertia::render('Docs/DiagnosticTest');
        })->name('docs.diagnostic_test');

        Route::get('/docs/division-manager', function () {
            return Inertia::render('Docs/DivisionManager');
        })->name('docs.division_manager');

        Route::get('/docs/edupreneurs', function () {
            return Inertia::render('Docs/Edupreneurs');
        })->name('docs.edupreneurs');

        Route::get('/docs/fee-invoices', function () {
            return Inertia::render('Docs/FeeInvoices');
        })->name('docs.fee_invoices');

        Route::get('/docs/math-manipulatives', function () {
            return Inertia::render('Docs/MathManipulatives');
        })->name('docs.math_manipulatives');

        Route::get('/docs/menu-editor', function () {
            return Inertia::render('Docs/MenuEditor');
        })->name('docs.menu_editor');

        Route::get('/docs/orders', function () {
            return Inertia::render('Docs/Orders');
        })->name('docs.orders');

        Route::get('/docs/permissions', function () {
            return Inertia::render('Docs/Permissions');
        })->name('docs.permissions');

        Route::get('/docs/products', function () {
            return Inertia::render('Docs/Products');
        })->name('docs.products');

        Route::get('/docs/programmes', function () {
            return Inertia::render('Docs/Programmes');
        })->name('docs.programmes');

        Route::get('/docs/progress-report', function () {
            return Inertia::render('Docs/ProgressReport');
        })->name('docs.progress_report');

        Route::get('/docs/roles', function () {
            return Inertia::render('Docs/Roles');
        })->name('docs.roles');

        Route::get('/docs/students', function () {
            return Inertia::render('Docs/Students');
        })->name('docs.students');

        Route::get('/docs/teacher-resources', function () {
            return Inertia::render('Docs/TeacherResources');
        })->name('docs.teacher_resources');

        Route::get('/docs/users', function () {
            return Inertia::render('Docs/Users');
        })->name('docs.users');

        Route::get('/docs/profile', function () {
            return Inertia::render('Docs/Profile');
        })->name('docs.profile');
    });
});