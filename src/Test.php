<?php

namespace Rowles;

use Psr\Log\LoggerInterface;

class Test {
    public function do() {
        app(LoggerInterface::class)->info('test');
    }
}