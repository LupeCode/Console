<?php

use LupeCode\Console\Console;
use LupeCode\Console\Helpers\Color;
use LupeCode\Console\Helpers\Color16;
use LupeCode\Console\Helpers\Color256;

require_once __DIR__ . '/../vendor/autoload.php';

$sleep = 500000;

require_once __DIR__ . '/basic.php';
basicTest($sleep);

require_once __DIR__ . '/color256.php';
color265Test();
usleep($sleep);

require_once __DIR__ . '/progressBar.php';
progressBarTest();
usleep($sleep);

require_once __DIR__ . '/advancedANSI.php';
advancedANSI();
usleep($sleep);

require_once __DIR__ . '/table.php';
usleep($sleep);

require_once __DIR__ . '/exception.php';
try {
    Console::printHeader('Stack Trace Test');
    usleep($sleep);
    throwException('This is part of the test, not a real error');
} catch (\Exception $exception) {
    Console::printErrorWithTrace([$exception->getMessage()], [], $exception->getTrace());
}

