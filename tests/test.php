<?php

use LupeCode\Console\Console;
use LupeCode\Console\Helpers\Color;
use LupeCode\Console\Helpers\Color16;
use LupeCode\Console\Helpers\Color256;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    // Console::$debugMode = true;
    Console::printHeader('Header Message');
    Console::printDebug('Debug Message');
    Console::printError('Error Message');
    Console::printStatus('Status Message');
    Console::printSuccess('Success Message');
    Console::print("Print No \\n", false);
    Console::printLine("\tPrint on the same line");
    Console::printLine('Print Line, No Color');
    Console::printLine('Print Line In Color', (new Color16())->setBackgroundColor(Color::YELLOW)->setForegroundColor(Color::BLACK)->setFlag(Color::BOLD));
    Console::printRainbow('Rainbow Text!', false, [], true);
    Console::printRainbow('Painbow Text!', true, [Color::BLINK, Color::UNDERLINE, Color::BOLD], true);
    Console::printRainbow256('This is a sample of the rainbow 256 color formatter.', false, [], true);
    Console::printRainbow256('This is a sample of the rainbow 256 color formatter with background rainbow coloring.', true, [], true);
    Console::printStatus(Console::promptReadline('Enter anything'));
    Console::printSuccess(Console::optionsReadline('Choose 1', [1 => 'Apple', 'Banana', 'Coconut'], "\n> ", true));
    // color265Test();
    // progressBarTest();
    // Console::printHeader("Stack Trace Test");
    // throwException("String", 4, 3.14159, false);
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

function color265Test()
{
    Console::printHeader('256 RGB Color Test');
    for ($r = 0; $r < 6; $r++) {
        Console::printColor(" R $r ", (new Color256())->setBackgroundColorRGB(5, 0, 0)->setForegroundColorRGB(0, 5, 5));
        for ($b = 0; $b < 6; $b++) {
            Console::printColor(" B $b ", (new Color256())->setBackgroundColorRGB(0, 0, 5)->setForegroundColorRGB(5, 5, 0));
        }
        echo PHP_EOL;
        for ($g = 0; $g < 6; $g++) {
            Console::printColor(" G $g ", (new Color256())->setBackgroundColorRGB(0, 5, 0)->setForegroundColorRGB(5, 0, 5));
            for ($b = 0; $b < 6; $b++) {
                Console::printColor('     ', (new Color256())->setBackgroundColorRGB($r, $g, $b));
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
    $sleep = 5000;
    $limit = 100;
    $size  = 33;
    Console::printHeader('Testing Progress Bar');
    Console::printStatus("Bar of size $size");
    $pBar = Console::progressBar();
    $pBar->setBarSize($size)->setTotal($limit)->startTimer();
    for ($i = 0; $i < $limit; $i++) {
        $pBar->increment();
        usleep($sleep);
    }
    $pBar->finish();
    Console::printStatus("Bar of size $size * 2 with background");
    $pBar->setBarSize($size * 2)->setTotal($limit)->setBarBackColor(Color::BLUE)->setBarForeColor(Color::YELLOW)->startTimer();
    for ($i = 0; $i < $limit; $i++) {
        $pBar->increment();
        usleep($sleep);
    }
    $pBar->finish();
    Console::printStatus("Rainbow bar of size $size * 3");
    $pBar->setBarSize($size * 3)->setTotal($limit)->setRainbowMode(true)->startTimer();
    for ($i = 0; $i < $limit; $i++) {
        $pBar->increment();
        usleep($sleep);
    }
    $pBar->finish();
    Console::printStatus("Rainbow256 bar of size $size * 3");
    $pBar->setBarSize($size * 3)->setTotal($limit)->setRainbow256Mode(true)->startTimer();
    for ($i = 0; $i < $limit; $i++) {
        $pBar->increment();
        usleep($sleep);
    }
    $pBar->finish();
    Console::printStatus("Rainbow256 bar of size $size * 3 with back and forth movement");
    $pBar->setBarSize($size * 3)->setTotal($limit)->setRainbow256Mode(true)->startTimer();
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
    echo PHP_EOL;
}
