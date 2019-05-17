<?php

use LupeCode\Console\Console;
use LupeCode\Console\Helpers\Color;
use LupeCode\Console\Helpers\Color16;
use LupeCode\Console\Helpers\Color256;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $sleep = 500000;
    // Console::$debugMode = true;
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
    color265Test();
    usleep($sleep);
    progressBarTest();
    usleep($sleep);
    advancedANSI();
    usleep($sleep);
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

function advancedANSI()
{
    Console::printHeader('Advanced ANSI Code Test');
    $sleep = 1000000;
    Console::printStatus('Here is a line, the cursor is moved to the beginning',null,false);
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

function color265Test()
{
    Console::printHeader('256 RGB Color Test');
    for ($r = 0; $r < 6; $r++) {
        Console::printColor(" R $r ", (new Color256())->setBackgroundColorRGB(5, 0, 0)->setForegroundColorRGB(0, 5, 5), false);
        for ($b = 0; $b < 6; $b++) {
            Console::printColor(" B $b ", (new Color256())->setBackgroundColorRGB(0, 0, 5)->setForegroundColorRGB(5, 5, 0), false);
        }
        echo PHP_EOL;
        for ($g = 0; $g < 6; $g++) {
            Console::printColor(" G $g ", (new Color256())->setBackgroundColorRGB(0, 5, 0)->setForegroundColorRGB(5, 0, 5), false);
            for ($b = 0; $b < 6; $b++) {
                Console::printColor('     ', (new Color256())->setBackgroundColorRGB($r, $g, $b), false);
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
    Console::printHeader('Grayscale Test');
    for ($a = 0; $a < 24; $a++) {
        Console::printLine("Grayscale Level $a", (new Color256())->setBackgroundColorGrayscale($a)->setForegroundColor(Color::RED));
    }
    echo PHP_EOL;
}

function progressBarTest()
{
    $sleep = 10000;
    $limit = 100;
    $size  = 33;
    Console::printHeader('Progress Bar Test');
    Console::printStatus("Bar of size $size");
    $pBar = Console::progressBar();
    $pBar->setBarSize($size)->setTotal($limit)->startTimer();
    for ($i = 0; $i < $limit; $i++) {
        $pBar->increment();
        usleep($sleep);
    }
    $pBar->finish();
    $size = 50;
    Console::printStatus("Bar of size $size with background");
    $pBar->setBarSize($size)->setTotal($limit)->setBarBackColor(Color::BLUE)->setBarForeColor(Color::YELLOW)->startTimer();
    for ($i = 0; $i < $limit; $i++) {
        $pBar->increment();
        usleep($sleep);
    }
    $pBar->finish();
    Console::printStatus("Rainbow bar of size $size");
    $pBar->setBarSize($size)->setTotal($limit)->setRainbowMode(true)->startTimer();
    for ($i = 0; $i < $limit; $i++) {
        $pBar->increment();
        usleep($sleep);
    }
    $pBar->finish();
    Console::printStatus("Rainbow256 bar of size $size");
    $pBar->setBarSize($size)->setTotal($limit)->setRainbow256Mode(true)->startTimer();
    for ($i = 0; $i < $limit; $i++) {
        $pBar->increment();
        usleep($sleep);
    }
    $pBar->finish();
    Console::printStatus("Rainbow256 bar of size $size with back and forth movement");
    $pBar->setBarSize($size)->setTotal($limit)->setRainbow256Mode(true)->startTimer();
    $i = 0;
    for ($j = 0; $j < 2; $j++) {
        for (; $i < $limit * (4 / 5); $i++) {
            $pBar->increment();
            usleep($sleep);
        }
        for (; $i > $limit * (1 / 5); $i--) {
            $pBar->adjust(-1);
            usleep($sleep);
        }
    }
    for (; $i < $limit; $i++) {
        $pBar->increment();
        usleep($sleep);
    }
    $pBar->finish();
    Console::printStatus("Bar of size $size while printing text");
    $pBar->reset()->setBarSize($size)->setTotal($limit)->startTimer();
    for ($i = 0; $i < $limit; $i++) {
        if ($i % 20 === 0) {
            Console::printDebug('Woo, divisible by 20!');
        }
        $pBar->increment();
        usleep($sleep);
    }
    $pBar->finish();
    Console::printStatus("Bar of size $size with custom progress text");
    $pBar->reset()->setBarSize($size)->setTotal($limit)->setProgressText(' $2 of $3 done')->startTimer();
    for ($i = 0; $i < $limit; $i++) {
        if ($i % 20 === 0) {
            Console::printDebug('Woo, divisible by 20!');
        }
        $pBar->increment();
        usleep($sleep);
    }
    $pBar->finish();
}
