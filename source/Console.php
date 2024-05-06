<?php

namespace LupeCode\Console;

use LupeCode\Console\Helpers\Color;
use LupeCode\Console\Helpers\Color16;
use LupeCode\Console\Helpers\Color256;
use LupeCode\Console\Helpers\Controls\ControlSequenceIntroducer as CSI;
use LupeCode\Console\Helpers\Generator;
use LupeCode\Console\Helpers\ProgressBar;
use LupeCode\Console\Helpers\Table;

/**
 * Class Console
 *
 * @package LupeCode\Console
 */
class Console
{

    public static bool $debugMode = false;
    protected static int $errorCount = 0;
    protected static ProgressBar $progressBar;
    protected static Generator $generator;
    protected static Table $table;

    protected static function ensureProgressBar(bool $force = false): void
    {
        if (!isset(static::$progressBar) || $force) {
            static::$progressBar = new ProgressBar();
        }
    }

    protected static function ensureGenerator(bool $force = false): void
    {
        if (!isset(static::$generator) || $force) {
            static::$generator = new Generator();
        }
    }

    protected static function ensureTable(bool $force = false): void
    {
        if (!isset(static::$table) || $force) {
            static::$table = new Table();
        }
    }

    public static function progressBar(): ProgressBar
    {
        static::ensureProgressBar();

        return static::$progressBar;
    }

    public static function table(bool $reset = false): Table
    {
        static::ensureTable($reset);

        return static::$table;
    }

    public static function activateAlternateScreenBuffer(): void
    {
        static::print(CSI::ALT_BUFF_ON());
    }

    public static function deactivateAlternateScreenBuffer(): void
    {
        static::print(CSI::ALT_BUFF_OFF());
    }

    public static function printStatus(string $message, Color $overrideColor = null, bool $lineBreak = true): void
    {
        static::printLine($message, $overrideColor ?? (new Color16())->setForegroundColor(Color::CYAN), $lineBreak);
    }

    public static function printLine(string $message, Color $color = null, bool $lineBreak = true): void
    {
        if ($color === null) {
            static::print($message, $lineBreak);
        } else {
            static::printColor($message, $color, $lineBreak);
        }
    }

    public static function print(string $message, bool $lineBreak = false): void
    {
        if (static::progressBar() !== null && static::progressBar()->isShowing()) {
            static::progressBar()->clear();
        }
        if (static::$debugMode) {
            echo "Debug Print:\n\t" . str_replace("\e", '^', $message) . PHP_EOL;
        }
        echo $message;
        if ($lineBreak) {
            echo PHP_EOL;
        }
        if (static::progressBar() !== null && static::progressBar()->isShowing()) {
            static::progressBar()->update();
        }
    }

    public static function printColor(string $message, Color $color, bool $lineBreak = true): void
    {
        if (static::progressBar() !== null && static::progressBar()->isShowing()) {
            static::progressBar()->clear();
        }
        static::ensureGenerator();
        static::print(static::$generator->genColor($message, $color), $lineBreak);
        if (static::progressBar() !== null && static::progressBar()->isShowing()) {
            static::progressBar()->update();
        }
    }

    public static function readline(string $prompt = "\n> "): string
    {
        echo $prompt;

        return \trim(\readline());
    }

    public static function promptReadline(string $message, string $prompt = "\n> ", bool $lineBreak = true): string
    {
        static::print($message, $lineBreak);

        return static::readline($prompt);
    }

    public static function optionsReadline(string $message, array $options, string $prompt = "\n> ", bool $returnValue = false): mixed
    {
        $choice = '';
        while (!\array_key_exists($choice, $options)) {
            static::print($message, true);
            foreach ($options as $index => $value) {
                static::print(str_pad('[' . $index . ']', 7, ' ', STR_PAD_LEFT) . ' ' . $value, true);
            }
            $choice = static::readline($prompt);
        }

        return $returnValue ? $options[$choice] : $choice;
    }

    public static function promptColorReadlline(string $message, Color $color, string $prompt = "\n> ", bool $lineBreak = true): string
    {
        static::printColor($message, $color, $lineBreak);

        return static::readline($prompt);
    }

    public static function printSuccess(string $message): void
    {
        static::printLine($message, (new Color16())->setForegroundColor(Color::GREEN));
    }

    public static function printError(string $message, bool $force = false): void
    {
        if (static::$errorCount < 5 || $force) {
            static::printLine($message, (new Color16())->setForegroundColor(Color::RED));
        }
    }

    public static function printDebug(string $message): void
    {
        static::printLine($message, (new Color16())->setForegroundColor(Color::BLACK, true));
    }

    public static function printHeader(string $message): void
    {
        $bar = str_pad('', \strlen($message) + 4, '=');
        $message = "$bar\n| $message |\n$bar";
        static::printLine($message, (new Color16())->setForegroundColor(Color::YELLOW));
    }

    public static function printRainbow(string $message, bool $useBackColors = false, array $flags = [], $lineBreak = false): void
    {
        static::ensureGenerator();
        static::print(static::$generator->genRainbow($message, $useBackColors, $flags), $lineBreak);
    }

    public static function printRainbow256(string $message, bool $useBackColors = false, array $flags = [], $lineBreak = false): void
    {
        static::ensureGenerator();
        static::print(static::$generator->genRainbow256($message, $useBackColors, $flags), $lineBreak);
    }

    public static function dieWithTrace(array $error_messages, array $debug_messages = null, array $backtrace = null): void
    {
        static::printErrorWithTrace($error_messages, $debug_messages, $backtrace);
        exit(1);
    }

    public static function printErrorWithTrace(array $error_messages, array $debug_messages = null, array $backtrace = null): void
    {
        static::printError(implode(PHP_EOL, $error_messages));
        if (!empty($debug_messages)) {
            static::printDebug(implode(PHP_EOL, $debug_messages));
        }

        static::printLine('STACK TRACE', (new Color16())->setForegroundColor(Color::YELLOW));
        if ($backtrace === null) {
            $backtrace = debug_backtrace();
        }
        foreach ($backtrace as $index => $trace) {
            if (empty($trace['class'])) {
                $trace['class'] = '';
            }
            if (empty($trace['type'])) {
                $trace['type'] = '';
            }
            if (empty($trace['function'])) {
                $trace['function'] = '';
            }
            if (empty($trace['args'])) {
                $trace['args'] = [];
            }
            static::printLine("#{$index} => {$trace['file']}:{$trace['line']}", (new Color16())->setForegroundColor(Color::RED, true)->setBackgroundColor(Color::BLUE));
            static::printLine("\t#{$trace['class']}{$trace['type']}{$trace['function']}", (new Color16())->setForegroundColor(Color::YELLOW, true));
            foreach ($trace['args'] as $arg) {
                static::printLine("\t\t" . var_export($arg, true));
            }
        }
    }

}
