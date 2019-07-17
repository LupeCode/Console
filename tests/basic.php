<?php

use LupeCode\Console\Console;
use LupeCode\Console\Helpers\Color;
use LupeCode\Console\Helpers\Color16;

function basicTest($sleep)
{
    Console::printHeader('Header Message');
    usleep($sleep);
    Console::printDebug('Debug Message');
    usleep($sleep);
    Console::printError('Error Message');
    usleep($sleep);
    Console::printStatus('Status Message');
    usleep($sleep);
    Console::printSuccess('Success Message');
    usleep($sleep);
    Console::print("Print No \\n", false);
    usleep($sleep);
    Console::printLine("\tPrint on the same line");
    usleep($sleep);
    Console::printLine('Print Line, No Color');
    usleep($sleep);
    Console::printLine('Print Line In Color', (new Color16())->setBackgroundColor(Color::YELLOW)->setForegroundColor(Color::BLACK)->setFlag(Color::BOLD));
    usleep($sleep);
    Console::printRainbow('Rainbow Text!', false, [], true);
    usleep($sleep);
    Console::printRainbow('Painbow Text!', true, [Color::BLINK, Color::UNDERLINE, Color::BOLD], true);
    usleep($sleep);
    Console::printRainbow256('This is a sample of the rainbow 256 color formatter.', false, [], true);
    usleep($sleep);
    Console::printRainbow256('This is a sample of the rainbow 256 color formatter with background rainbow coloring.', true, [], true);
    usleep($sleep);
    Console::printHeader('Input Test');
    usleep($sleep);
    Console::printStatus(Console::promptReadline('Enter anything'));
    usleep($sleep);
    Console::printSuccess(Console::optionsReadline('Choose 1', [1 => 'Apple', 'Banana', 'Coconut'], "\n> ", true));
    usleep($sleep);
}
