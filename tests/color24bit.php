<?php

use LupeCode\Console\Console;
use LupeCode\Console\Helpers\Color;
use LupeCode\Console\Helpers\Color24Bit;

require_once __DIR__ . '/../vendor/autoload.php';

color24BitTest();

function color24BitTest()
{
    Console::printHeader('24-Bit RGB Color Test');
    for ($r = 0; $r < 6; $r++) {
        Console::printColor(" R $r ", (new Color24Bit())->setBackgroundColorRGB(5, 0, 0)->setForegroundColorRGB(0, 5, 5), false);
        for ($b = 0; $b < 6; $b++) {
            Console::printColor(" B $b ", (new Color24Bit())->setBackgroundColorRGB(0, 0, 5)->setForegroundColorRGB(5, 5, 0), false);
        }
        echo PHP_EOL;
        for ($g = 0; $g < 6; $g++) {
            Console::printColor(" G $g ", (new Color24Bit())->setBackgroundColorRGB(0, 5, 0)->setForegroundColorRGB(5, 0, 5), false);
            for ($b = 0; $b < 6; $b++) {
                Console::printColor('     ', (new Color24Bit())->setBackgroundColorRGB($r, $g, $b), false);
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
