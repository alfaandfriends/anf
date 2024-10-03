<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Profile
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Profile', route('profile'));
});

/* Dashboard */
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
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

Breadcrumbs::for('centres.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('centres');
    $trail->push('Edit Centre', route('centres'));
});

/* Division Manager */
Breadcrumbs::for('division_manager', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Division Manager', route('division_manager'));
});

Breadcrumbs::for('division_manager.manage', function (BreadcrumbTrail $trail) {
    $trail->parent('division_manager');
    $trail->push('Manage Division Manager', route('division_manager'));
});

/* Centre Manager */
Breadcrumbs::for('centre_manager', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Centre Manager', route('centre_manager'));
});

Breadcrumbs::for('centre_manager.manage', function (BreadcrumbTrail $trail) {
    $trail->parent('centre_manager');
    $trail->push('Manage Centre Manager', route('centre_manager'));
});

/* Edupreneurs */
Breadcrumbs::for('edupreneurs', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Edupreneurs', route('edupreneurs'));
});

Breadcrumbs::for('edupreneurs.manage', function (BreadcrumbTrail $trail) {
    $trail->parent('edupreneurs');
    $trail->push('Manage Edupreneurs', route('edupreneurs'));
});

/* Teachers */
Breadcrumbs::for('teachers', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Teachers', route('teachers'));
});

Breadcrumbs::for('teachers.manage', function (BreadcrumbTrail $trail) {
    $trail->parent('teachers');
    $trail->push('Manage Teachers', route('teachers'));
});

/* Programmes */
Breadcrumbs::for('programmes', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Programmes', route('programmes'));
});

Breadcrumbs::for('programmes.create', function (BreadcrumbTrail $trail) {
    $trail->parent('programmes');
    $trail->push('Add Programme', route('programmes'));
});

Breadcrumbs::for('programmes.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('programmes');
    $trail->push('Edit Programme', route('programmes'));
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

/* Students */
Breadcrumbs::for('students', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Students', route('students'));
});

Breadcrumbs::for('students.inactive', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Students', route('students.inactive'));
});

Breadcrumbs::for('students.on_break', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Students', route('students.on_break'));
});

Breadcrumbs::for('students.unassigned', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Students', route('students.unassigned'));
});

Breadcrumbs::for('students.create', function (BreadcrumbTrail $trail) {
    $trail->parent('students');
    $trail->push('Add Student', route('students'));
});

Breadcrumbs::for('students.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('students');
    $trail->push('Edit Student', route('students'));
});

/* Art Gallery */
Breadcrumbs::for('art_gallery', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Art Gallery', route('art_gallery'));
});

Breadcrumbs::for('art_gallery.create', function (BreadcrumbTrail $trail) {
    $trail->parent('art_gallery');
    $trail->push('Add Artwork', route('art_gallery'));
});

Breadcrumbs::for('art_gallery.setting.levels', function (BreadcrumbTrail $trail) {
    $trail->parent('art_gallery');
    $trail->push('Level Setting', route('art_gallery.setting.levels'));
});

Breadcrumbs::for('art_gallery.setting.themes', function (BreadcrumbTrail $trail) {
    $trail->parent('art_gallery');
    $trail->push('Theme setting', route('art_gallery.setting.themes'));
});

Breadcrumbs::for('art_gallery.setting.lessons', function (BreadcrumbTrail $trail) {
    $trail->parent('art_gallery');
    $trail->push('Lesson Setting', route('art_gallery.setting.lessons'));
});

Breadcrumbs::for('art_gallery.setting.activities', function (BreadcrumbTrail $trail) {
    $trail->parent('art_gallery');
    $trail->push('Activity Setting', route('art_gallery.setting.activities'));
});

/* Progress report */
Breadcrumbs::for('progress_report', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Progress Report', route('progress_report'));
});

Breadcrumbs::for('progress_report.details', function (BreadcrumbTrail $trail) {
    $trail->parent('progress_report');
    $trail->push('Details', route('progress_report'));
});

/* Progress report Setting */
Breadcrumbs::for('progress_report.settings', function (BreadcrumbTrail $trail) {
    $trail->parent('progress_report');
    $trail->push('Settings', route('progress_report.settings'));
});

    /* Math */
    Breadcrumbs::for('progress_report.settings.math.levels', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Levels', route('progress_report.settings.math.levels'));
    });

    Breadcrumbs::for('progress_report.settings.math.terms_books', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Terms / Books', route('progress_report.settings.math.terms_books'));
    });

    Breadcrumbs::for('progress_report.settings.math.units', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Units', route('progress_report.settings.math.units'));
    });

    Breadcrumbs::for('progress_report.settings.math.lessons', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Lessons', route('progress_report.settings.math.lessons'));
    });

    Breadcrumbs::for('progress_report.settings.math.objectives', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Objectives', route('progress_report.settings.math.objectives'));
    });

    /* Coding & Robotics */
    Breadcrumbs::for('progress_report.settings.coding_robotics.levels', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Levels', route('progress_report.settings.coding_robotics.levels'));
    });

    Breadcrumbs::for('progress_report.settings.coding_robotics.lessons', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Lessons', route('progress_report.settings.coding_robotics.lessons'));
    });

    Breadcrumbs::for('progress_report.settings.coding_robotics.topics', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Topics', route('progress_report.settings.coding_robotics.topics'));
    });

    Breadcrumbs::for('progress_report.settings.coding_robotics.objectives', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Objectives', route('progress_report.settings.coding_robotics.objectives'));
    });

    Breadcrumbs::for('progress_report.settings.coding_robotics.activities_procedures', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Activities & Procedures', route('progress_report.settings.coding_robotics.activities_procedures'));
    });

    /* Digital Art */
    Breadcrumbs::for('progress_report.settings.digital_art.levels', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Levels', route('progress_report.settings.digital_art.levels'));
    });

    Breadcrumbs::for('progress_report.settings.digital_art.themes', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Themes', route('progress_report.settings.digital_art.themes'));
    });

    Breadcrumbs::for('progress_report.settings.digital_art.lessons', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Lessons', route('progress_report.settings.digital_art.lessons'));
    });

    Breadcrumbs::for('progress_report.settings.digital_art.activities', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Activities', route('progress_report.settings.digital_art.activities'));
    });

    Breadcrumbs::for('progress_report.settings.digital_art.outcomes', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Outcomes', route('progress_report.settings.digital_art.outcomes'));
    });

    Breadcrumbs::for('progress_report.settings.digital_art.objectives', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Objectives', route('progress_report.settings.digital_art.objectives'));
    });

    /* Little Bot */
    Breadcrumbs::for('progress_report.settings.little_bot.levels', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Levels', route('progress_report.settings.little_bot.levels'));
    });

    Breadcrumbs::for('progress_report.settings.little_bot.lessons', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Lessons', route('progress_report.settings.little_bot.lessons'));
    });

    Breadcrumbs::for('progress_report.settings.little_bot.topics', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Topics', route('progress_report.settings.little_bot.topics'));
    });

    Breadcrumbs::for('progress_report.settings.little_bot.objectives', function (BreadcrumbTrail $trail) {
        $trail->parent('progress_report.settings');
        $trail->push('Objectives', route('progress_report.settings.little_bot.objectives'));
    });

/* Teacher Resources */
Breadcrumbs::for('teacher_resources', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Teacher Resources', route('teacher_resources'));
});

Breadcrumbs::for('teacher_resources.create', function (BreadcrumbTrail $trail) {
    $trail->parent('teacher_resources');
    $trail->push('Add Resource', route('teacher_resources'));
});

Breadcrumbs::for('teacher_resources.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('teacher_resources');
    $trail->push('Edit Resource', route('teacher_resources'));
});

/* Math Manipulatives */
Breadcrumbs::for('math_manipulatives', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Math Manipulatives', route('math_manipulatives'));
});

Breadcrumbs::for('math_manipulatives.configuration', function (BreadcrumbTrail $trail) {
    $trail->parent('math_manipulatives');
    $trail->push('Configuration', route('math_manipulatives.configuration'));
});

Breadcrumbs::for('math_manipulatives.configuration.create', function (BreadcrumbTrail $trail) {
    $trail->parent('math_manipulatives.configuration');
    $trail->push('Add Math Manipulative', route('math_manipulatives.configuration.create'));
});

/* Diagnostic Test Settings */
Breadcrumbs::for('diagnostic_test.saved_result', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Diagnostic Test Saved Result', route('diagnostic_test.saved_result'));
});

Breadcrumbs::for('diagnostic_test.saved_result.details', function (BreadcrumbTrail $trail) {
    $trail->parent('diagnostic_test.saved_result');
    $trail->push('Details', route('diagnostic_test.saved_result.details'));
});

Breadcrumbs::for('dt.settings', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Diagnostic Test Settings', route('dt.settings'));
});

/* Diagnostic Test Language Settings */
Breadcrumbs::for('dt.settings.languages', function (BreadcrumbTrail $trail) {
    $trail->parent('dt.settings');
    $trail->push('Languages', route('dt.settings.languages'));
});

Breadcrumbs::for('dt.settings.create', function (BreadcrumbTrail $trail) {
    $trail->parent('dt.settings');
    $trail->push('Add Test', route('dt.settings.create'));
});

Breadcrumbs::for('dt.settings.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('dt.settings');
    $trail->push('Edit Test', route('dt.settings.edit'));
});

Breadcrumbs::for('dt.settings.details', function (BreadcrumbTrail $trail) {
    $trail->parent('dt.settings');
    $trail->push('Details', route('dt.settings.details'));
});

Breadcrumbs::for('dt.settings.categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('dt.settings');
    $trail->push('Create Category', route('dt.settings.categories.create'));
});

Breadcrumbs::for('dt.settings.categories.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('dt.settings');
    $trail->push('Edit Category', route('dt.settings.categories.edit'));
});

Breadcrumbs::for('dt.settings.details.create', function (BreadcrumbTrail $trail) {
    $trail->parent('dt.settings');
    $trail->push('Create Question', route('dt.settings.details.create'));
});

Breadcrumbs::for('dt.settings.details.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('dt.settings');
    $trail->push('Edit Question', route('dt.settings.details.edit'));
});

/* Fee Invoices */
Breadcrumbs::for('fee.invoices', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Fee Invoices', route('fee.invoices'));
});

Breadcrumbs::for('fee.invoices.create', function (BreadcrumbTrail $trail) {
    $trail->parent('fee.invoices');
    $trail->push('Add Invoice', route('fee.invoices.create'));
});

Breadcrumbs::for('fee.invoices.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('fee.invoices');
    $trail->push('Edit Invoice', route('fee.invoices.edit'));
});

/* Promotions */
Breadcrumbs::for('fee.promos', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Promotions', route('fee.promos'));
});

Breadcrumbs::for('fee.promos.create', function (BreadcrumbTrail $trail) {
    $trail->parent('fee.promos');
    $trail->push('Add Promotion', route('fee.promos.create'));
});

/* Products */
Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Products', route('products'));
});

Breadcrumbs::for('products.create', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Add Product', route('products.create'));
});

Breadcrumbs::for('products.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Edit Product', route('products.edit'));
});

/* Orders */
Breadcrumbs::for('orders', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Orders', route('orders'));
});

Breadcrumbs::for('orders.create', function (BreadcrumbTrail $trail) {
    $trail->parent('orders');
    $trail->push('Add Order', route('orders.create'));
});

Breadcrumbs::for('orders.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('orders');
    $trail->push('Edit Order', route('orders.edit'));
});

/* Users */
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('users'));
});

Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Add User', route('users'));
});

Breadcrumbs::for('users.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Manage User', route('users.edit'));
});

/* Countries */
Breadcrumbs::for('countries', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Countries', route('countries'));
});

Breadcrumbs::for('countries.create', function (BreadcrumbTrail $trail) {
    $trail->parent('countries');
    $trail->push('Add Country', route('countries.create'));
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
    $trail->push('Manage Permission', route('roles'));
});

/* Permissions */
Breadcrumbs::for('permissions', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Permissions', route('permissions'));
});

Breadcrumbs::for('permissions.create', function (BreadcrumbTrail $trail) {
    $trail->parent('permissions');
    $trail->push('Add Permission', route('permissions.create'));
});

Breadcrumbs::for('permissions.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('permissions');
    $trail->push('Edit Permission', route('permissions.edit'));
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
