<?php

use LupeCode\Console\Console;
use LupeCode\Console\Helpers\Color;
use LupeCode\Console\Helpers\Color256;

require_once __DIR__ . '/../vendor/autoload.php';

color265Test();

function color265Test()
{
    $sleep = 10000;
    Console::printHeader('256 RGB Color Test');
    for ($r = 0; $r < 6; $r++) {
        Console::printColor(" R $r ", (new Color256())->setBackgroundColorRGB(5, 0, 0)->setForegroundColorRGB(0, 5, 5), false);
        usleep($sleep);
        for ($b = 0; $b < 6; $b++) {
            Console::printColor(" B $b ", (new Color256())->setBackgroundColorRGB(0, 0, 5)->setForegroundColorRGB(5, 5, 0), false);
            usleep($sleep);
        }
        echo PHP_EOL;
        for ($g = 0; $g < 6; $g++) {
            Console::printColor(" G $g ", (new Color256())->setBackgroundColorRGB(0, 5, 0)->setForegroundColorRGB(5, 0, 5), false);
            usleep($sleep);
            for ($b = 0; $b < 6; $b++) {
                Console::printColor('     ', (new Color256())->setBackgroundColorRGB($r, $g, $b), false);
                usleep($sleep);
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
    Console::printHeader('Grayscale Test');
    for ($a = 0; $a < 24; $a++) {
        Console::printLine("Grayscale Background Level $a, Foreground Level " . (23 - $a), (new Color256())->setBackgroundColorGrayscale($a)->setForegroundColorGrayscale(23 - $a));
        usleep($sleep);
    }
    echo PHP_EOL;
    Console::printRainbow256('This is a sample of the rainbow 256 color formatter.', false, [], true);
    usleep($sleep);
    Console::printRainbow256('This is a sample of the rainbow 256 color formatter with background rainbow coloring.', true, [], true);
    usleep($sleep);
}
