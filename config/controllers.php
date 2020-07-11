<?php

/*----------------------------------------
 | Register application controllers       |
 ----------------------------------------*/
$controllers = [
    'page' => new \Rowles\Controllers\PageController($app),
    'blog' => new \Rowles\Controllers\BlogController($app)
];

return extract($controllers);
