<?php

/*----------------------------------------
 | Configure application web routes       |
 ----------------------------------------*/
 
return [
    '/' => [
        ['GET', '/', [App\Http\Controllers\HomeController::class, 'index']]
    ],

    '/cms' => [

        ['GET', '/', [App\Http\Controllers\CMS\HomeController::class, 'index']],

        'employment-history' => [
            ['GET',    '/create',      [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'create']],
            ['POST',   '/create',      [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'store']],
            ['GET',    '/edit/{id}',   [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'edit']],
            ['PUT',    '/edit/{id}',   [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'update']],
            ['DELETE', '/delete/{id}', [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'delete']],
        ],

        'contact-detail' => [
            ['GET',    '/create',      [App\Http\Controllers\CMS\ContactDetailController::class, 'create']],
            ['POST',   '/create',      [App\Http\Controllers\CMS\ContactDetailController::class, 'store']],
            ['GET',    '/edit/{id}',   [App\Http\Controllers\CMS\ContactDetailController::class, 'edit']],
            ['PUT',    '/edit/{id}',   [App\Http\Controllers\CMS\ContactDetailController::class, 'update']],
            ['DELETE', '/delete/{id}', [App\Http\Controllers\CMS\ContactDetailController::class, 'delete']],
        ],
    ],
];