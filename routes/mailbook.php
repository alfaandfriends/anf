<?php

use App\Mail\DiagnosticTest\ResultToParent;
use App\Mail\DiagnosticTest\ResultToPIC;
use Xammie\Mailbook\Facades\Mailbook;

Mailbook::add(function (): ResultToParent {
    $data = [
        ['name' => 'John Doe', 'id' => 'asd'],
        ['name' => 'Jane Doe', 'id' => 'asd'],
    ];
    return new ResultToParent($data, '/example/url');
});

Mailbook::add(function (): ResultToPIC {
    $data['pic_name']       =   'Raof';
    $data['student_name']   =   'Rami';
    $data['student_age']    =   '4';
    $data['dt_title']       =   'Test';
    $data['test_date']      =   '21/08/2023';
    $data['reports'] = [
        ['name' => 'John Doe', 'id' => 'asd'],
        ['name' => 'Jane Doe', 'id' => 'asd'],
    ];
    $data['parent_name']            =   'Raof';
    $data['parent_contact']         =   '0102063234';
    $data['parent_area_location']   =   'Puchong';
    $data['parent_email']           =   'abdulraof628@gmail.com';
    return new ResultToPIC($data, '/example/url');
});

