<?php

/*----------------------------------------
 | Configure application web routes       |
 ----------------------------------------*/
 
return [
  ['GET', '/', [App\Controllers\HomeController::class, 'index']],
  ['GET', '/about', [App\Controllers\AboutController::class, 'index']],
];