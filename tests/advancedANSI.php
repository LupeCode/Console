<?php

use LupeCode\Console\Console;
use LupeCode\Console\Helpers\Color256;
use LupeCode\Console\Helpers\Controls\ControlSequenceIntroducer as CSI;

require_once __DIR__ . '/../vendor/autoload.php';

advancedANSI();

function advancedANSI()
{
    Console::activateAlternateScreenBuffer();
    Console::printHeader('Advanced ANSI Code Test - Using Alternate Screen Buffer');

    Console::printStatus('Here is a line, the cursor is moved to the beginning', null, false);
    Console::print(CSI::CHA());
    resume();

    Console::printStatus('That line is partially overwritten', null, false);
    resume();

    Console::print(CSI::CHA() . CSI::EL() . CSI::CUD());
    Console::printStatus('That line is deleted');
    resume();

    Console::printStatus('The cursor is in the top left of the screen');
    Console::print(CSI::CUP());
    resume();

    Console::print(
        (new Color256())->setForegroundColorRGB(0, 0, 5)->setBackgroundColorRGB(2, 2, 1)->getEscapeSequence()
        . CSI::ED(CSI::ED_ENTIRE_SCREEN)
        . CSI::CUP(5, 10) . 'The screen is cleared'
        . CSI::CUP(6, 10) . 'The background color and foreground color have been set for the whole screen'
        . CSI::SGR()
    );
    resume();

    Console::deactivateAlternateScreenBuffer();
}

function resume()
{
    sleep(3);
}
