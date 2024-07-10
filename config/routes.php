<?php

/*----------------------------------------
 | Configure application routes           |
 ----------------------------------------*/
 
return [
  ['GET', '/', [App\Controllers\HomeController::class, 'index']]
];