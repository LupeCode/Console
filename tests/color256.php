<?php

use LupeCode\Console\Console;
use LupeCode\Console\Helpers\Color;
use LupeCode\Console\Helpers\Color256;

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
