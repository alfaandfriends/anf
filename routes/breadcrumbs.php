<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Profile
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Profile', route('profile'));
});

/* Users */
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('users'));
});

Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('User Registration', route('users'));
});

Breadcrumbs::for('users.assign_roles', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Assign Roles', route('users'));
});

/* Centres */
Breadcrumbs::for('centres', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Centres', route('centres'));
});

Breadcrumbs::for('centres.create', function (BreadcrumbTrail $trail) {
    $trail->parent('centres');
    $trail->push('Add Centre', route('centres'));
});

/* Roles */
Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Roles', route('roles'));
});

Breadcrumbs::for('roles.create', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push('Add Role', route('roles'));
});

Breadcrumbs::for('roles.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push('Edit Role', route('roles'));
});

Breadcrumbs::for('roles.assign_pemissions', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push('Assign Permission', route('roles'));
});

/* Centres */
Breadcrumbs::for('permissions', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Permissions', route('permissions'));
});

Breadcrumbs::for('permissions.create', function (BreadcrumbTrail $trail) {
    $trail->parent('permissions');
    $trail->push('Add Permission', route('permissions'));
});

/* Menus */
Breadcrumbs::for('menus', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Menus', route('menus'));
});

Breadcrumbs::for('menus.add_menu', function (BreadcrumbTrail $trail) {
    $trail->parent('menus');
    $trail->push('Add Menu', route('menus'));
});

Breadcrumbs::for('menus.edit_menu', function (BreadcrumbTrail $trail) {
    $trail->parent('menus');
    $trail->push('Edit Menu', route('menus'));
});

Breadcrumbs::for('menus.add_sub_menu', function (BreadcrumbTrail $trail) {
    $trail->parent('menus');
    $trail->push('Add Sub Menu', route('menus'));
});

Breadcrumbs::for('menus.edit_sub_menu', function (BreadcrumbTrail $trail) {
    $trail->parent('menus');
    $trail->push('Edit Sub Menu', route('menus'));
});

/* Classes */
Breadcrumbs::for('classes', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Classes', route('classes'));
});

Breadcrumbs::for('classes.create', function (BreadcrumbTrail $trail) {
    $trail->parent('classes');
    $trail->push('Add Class', route('classes'));
});

Breadcrumbs::for('classes.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('classes');
    $trail->push('Edit Class', route('classes'));
});

/* Classes */
Breadcrumbs::for('fees', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Fees', route('fees'));
});

Breadcrumbs::for('fees.create', function (BreadcrumbTrail $trail) {
    $trail->parent('fees');
    $trail->push('Add Fee', route('fees'));
});

Breadcrumbs::for('fees.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('fees');
    $trail->push('Edit Fee', route('fees'));
});

/* Settings */
Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Class Types Settings', route('settings.class_types'));
});

Breadcrumbs::for('settings.class_types', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Class Types Settings', route('settings.class_types'));
});

Breadcrumbs::for('settings.class_types.create', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.class_types');
    $trail->push('Add Class Type', route('settings.class_types'));
});

Breadcrumbs::for('settings.class_types.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.class_types');
    $trail->push('Edit Class Type', route('settings.class_types'));
});

Breadcrumbs::for('settings.countries', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Countries', route('settings.countries'));
});

Breadcrumbs::for('settings.diagnostic_test', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Diagnostic Test', route('settings.diagnostic_test'));
});

Breadcrumbs::for('settings.diagnostic_test.create', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.diagnostic_test');
    $trail->push('Add Diagnostic Test', route('settings.diagnostic_test'));
});

/* Diagnostic Test Settings */
Breadcrumbs::for('diagnostic_test.saved_result', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Saved Result', route('diagnostic_test.saved_result'));
});

// Breadcrumbs::for('fees.create', function (BreadcrumbTrail $trail) {
//     $trail->parent('fees');
//     $trail->push('Add Fee', route('fees'));
// });