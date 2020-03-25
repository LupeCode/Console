<?php

use LupeCode\Console\Console;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    Console::printHeader('Stack Trace Test');
    usleep($sleep);
    throwException('This is part of the test, not a real error');
} catch (\Exception $exception) {
    Console::printErrorWithTrace([$exception->getMessage()], [], $exception->getTrace());
}

/**
 * @param mixed ...$args
 *
 * @throws \Exception
 */
function throwException(...$args)
{
    throw new \Exception('Call to undefined country; long distance rates apply.');
}
