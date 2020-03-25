<?php

use LupeCode\Console\Console;

require_once __DIR__ . '/../vendor/autoload.php';

$sleep = 500000;

require_once __DIR__ . '/basic.php';
usleep($sleep);

require_once __DIR__ . '/color256.php';
usleep($sleep);

require_once __DIR__ . '/progressBar.php';
usleep($sleep);

require_once __DIR__ . '/advancedANSI.php';
usleep($sleep);

require_once __DIR__ . '/table.php';
usleep($sleep);

require_once __DIR__ . '/exception.php';
usleep($sleep);

Console::printSuccess('Tests are finished!');
