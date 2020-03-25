<?php

use LupeCode\Console\Console;
use LupeCode\Console\Helpers\Color;

require_once __DIR__ . '/../vendor/autoload.php';

progressBarTest();

function progressBarTest()
{
    $sleep = 10000;
    $limit = 200;
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
            $pBar->adjust(1);
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

    Console::printStatus("Bar of size $size with random values");
    $pBar->reset()->setBarSize($size)->setTotal($limit)->startTimer();
    for ($i = 0; $i < $limit / 10; $i++) {
        $pBar->setCurrent(mt_rand(0, $limit));
        usleep($sleep * 10);
    }
    $pBar->setCurrent($limit);
    $pBar->finish();
}

