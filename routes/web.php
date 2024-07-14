<?php

/*----------------------------------------
 | Configure application web routes       |
 ----------------------------------------*/
 
return [
    ['GET', '/', [App\Http\Controllers\HomeController::class, 'index']],

    // Simple CMS
    ['GET', '/cms', [App\Http\Controllers\CMS\HomeController::class, 'index']],

    // Employment history management
    ['GET',  '/cms/employment-history/create',    [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'create']],
    ['POST', '/cms/employment-history/create',    [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'store']],
    ['GET',  '/cms/employment-history/edit/{id}', [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'edit']],
    ['PUT',  '/cms/employment-history/edit/{id}', [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'update']],
    ['DELETE', '/cms/employment-history/delete/{id}', [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'delete']],

    // Contact detail management
    ['GET',  '/cms/contact-detail/create',    [App\Http\Controllers\CMS\ContactDetailController::class, 'create']],
    ['POST', '/cms/contact-detail/create',    [App\Http\Controllers\CMS\ContactDetailController::class, 'store']],
    ['GET',  '/cms/contact-detail/edit/{id}', [App\Http\Controllers\CMS\ContactDetailController::class, 'edit']],
    ['PUT',  '/cms/contact-detail/edit/{id}', [App\Http\Controllers\CMS\ContactDetailController::class, 'update']],
    ['DELETE', '/cms/contact-detail/delete/{id}', [App\Http\Controllers\CMS\ContactDetailController::class, 'delete']]
];