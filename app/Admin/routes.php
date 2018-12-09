<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->get('/import', 'ImportController@getImport')->name('import');
    $router->post('/import_parse', 'ImportController@parseImport')->name('import_parse');
    $router->post('/import_process', 'ImportController@processImport')->name('import_process');

    $router->resource('/admin-dashboard', 'AdminDashboardController');
    $router->resource('/emergency-contact', 'EmergencyContactsController');
    $router->resource('/auth/students', 'StudentController');
    $router->resource('/auth/teachers', 'FacultyController');
    $router->resource('/auth/officer-staff', 'OfficerController');
    $router->resource('/auth/bus-route-info', 'StudentBusroutingInfoController');
    $router->resource('/auth/bus', 'BusInfoController');
    $router->resource('/auth/driver', 'DriverInfoController');
    $router->resource('/auth/helper', 'HelperInfoController');
    $router->resource('/auth/user-role', 'UserRoleController');
    $router->resource('/auth/transport-notice', 'NoticeController');
    $router->resource('/auth/bus-type', 'BusTypeController');
    $router->resource('/auth/bus-schedule', 'BusScheduleController');
    $router->resource('/auth/point', 'PointsController');
    $router->resource('/auth/route', 'RoutesController');
    $router->resource('/auth/day', 'DaysController');
    $router->resource('/auth/time', 'TimesController');
    $router->resource('/auth/bus-student-info', 'BusStudentInfoController');

});
