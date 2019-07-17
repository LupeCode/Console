<?php

use LupeCode\Console\Console;

function advancedANSI()
{
    Console::printHeader('Advanced ANSI Code Test');
    $sleep = 1000000;
    Console::printStatus('Here is a line, the cursor is moved to the beginning', null, false);
    usleep($sleep);
    Console::print("\e[G");
    Console::printStatus('That line is partially overwritten', null, false);
    usleep($sleep);
    Console::print("\e[G\e[K");
    Console::printStatus('That line is deleted');
    usleep($sleep);
    // Console::printStatus('The cursor is in the top left of the screen');
    // Console::print("\e[H");
    // usleep($sleep);
    // Console::print("\e[J");
    // Console::printStatus('The screen is cleared');
}

