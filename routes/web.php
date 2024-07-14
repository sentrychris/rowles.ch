<?php

/*----------------------------------------
 | Configure application web routes       |
 ----------------------------------------*/
 
return [
  ['GET', '/', [App\Http\Controllers\HomeController::class, 'index']],

  // Simple CMS
  ['GET', '/cms', [App\Http\Controllers\CMS\HomeController::class, 'index']],

  // Employment history management
  ['GET', '/cms/create/employment-history',  [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'create']],
  ['POST', '/cms/create/employment-history', [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'store']],
  ['POST', '/cms/delete/employment-history', [App\Http\Controllers\CMS\EmploymentHistoryController::class, 'delete']],

  // Contact detail management
  ['GET', '/cms/create/contact-detail',  [App\Http\Controllers\CMS\ContactDetailController::class, 'create']],
  ['POST', '/cms/create/contact-detail', [App\Http\Controllers\CMS\ContactDetailController::class, 'store']],
  ['POST', '/cms/delete/contact-detail', [App\Http\Controllers\CMS\ContactDetailController::class, 'delete']],
];