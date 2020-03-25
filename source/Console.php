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

    public static    $debugMode = false;
    protected static $errorCount;
    /** @var ProgressBar */
    protected static $progressBar;
    /** @var Generator */
    protected static $generator;
    /** @var Table */
    protected static $table;

    /**
     * @param bool $force
     */
    protected static function ensureProgressBar($force = false)
    {
        if (static::$progressBar === null || $force) {
            static::$progressBar = new ProgressBar();
        }
    }

    /**
     * @param bool $force
     */
    protected static function ensureGenerator($force = false)
    {
        if (static::$generator === null || $force) {
            static::$generator = new Generator();
        }
    }

    /**
     * @param bool $force
     */
    protected static function ensureTable($force = false)
    {
        if(static::$table === null || $force){
            static::$table = new Table();
        }
    }

    /**
     * @return \LupeCode\Console\Helpers\ProgressBar
     */
    public static function progressBar()
    {
        static::ensureProgressBar();

        return static::$progressBar;
    }

    /**
     * @param bool $reset
     *
     * @return \LupeCode\Console\Helpers\Table
     */
    public static function table($reset = false)
    {
        static::ensureTable($reset);

        return static::$table;
    }

    public static function activateAlternateScreenBuffer()
    {
        static::print(CSI::ALT_BUFF_ON());
    }

    /**
     *
     */
    public static function deactivateAlternateScreenBuffer()
    {
        static::print(CSI::ALT_BUFF_OFF());
    }

    /**
     * @param string     $message
     * @param Color|null $overrideColor
     * @param bool       $lineBreak
     */
    public static function printStatus(string $message, Color $overrideColor = null, bool $lineBreak = true)
    {
        static::printLine($message, $overrideColor ?? (new Color16())->setForegroundColor(Color::CYAN), $lineBreak);
    }

    /**
     * @param string     $message
     * @param Color|null $color
     * @param bool       $lineBreak
     */
    public static function printLine(string $message, Color $color = null, bool $lineBreak = true)
    {
        if ($color === null) {
            static::print($message, $lineBreak);
        } else {
            static::printColor($message, $color, $lineBreak);
        }
    }

    /**
     * @param string $message
     * @param bool   $lineBreak
     */
    public static function print(string $message, bool $lineBreak = false)
    {
        if (static::$progressBar !== null && static::$progressBar->isShowing()) {
            static::$progressBar->clear();
        }
        if (static::$debugMode) {
            echo "Debug Print:\n\t" . str_replace("\e", '^', $message) . PHP_EOL;
        }
        echo $message;
        if ($lineBreak) {
            echo PHP_EOL;
        }
        if (static::$progressBar !== null && static::$progressBar->isShowing()) {
            static::$progressBar->update();
        }
    }

    /**
     * @param string $message
     * @param Color  $color
     * @param bool   $lineBreak
     */
    public static function printColor(string $message, Color $color, bool $lineBreak = true)
    {
        if (static::$progressBar !== null && static::$progressBar->isShowing()) {
            static::$progressBar->clear();
        }
        static::ensureGenerator();
        static::print(static::$generator->genColor($message, $color), $lineBreak);
        if (static::$progressBar !== null && static::$progressBar->isShowing()) {
            static::$progressBar->update();
        }
    }

    /**
     * @param string $prompt
     *
     * @return string
     */
    public static function readline(string $prompt = "\n> ")
    {
        echo $prompt;

        return \trim(\readline());
    }

    /**
     * @param string $message
     * @param string $prompt
     * @param bool   $lineBreak
     *
     * @return string
     */
    public static function promptReadline(string $message, string $prompt = "\n> ", bool $lineBreak = true)
    {
        static::print($message, $lineBreak);

        return static::readline($prompt);
    }

    /**
     * @param string $message
     * @param array  $options
     * @param string $prompt
     * @param bool   $returnValue
     *
     * @return mixed|string
     */
    public static function optionsReadline(string $message, array $options, string $prompt = "\n> ", bool $returnValue = false)
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

    /**
     * @param string $message
     * @param Color  $color
     * @param string $prompt
     * @param bool   $lineBreak
     *
     * @return string
     */
    public static function promptColorReadlline(string $message, Color $color, string $prompt = "\n> ", bool $lineBreak = true)
    {
        static::printColor($message, $color, $lineBreak);

        return static::readline($prompt);
    }

    /**
     * @param string $message
     */
    public static function printSuccess(string $message)
    {
        static::printLine($message, (new Color16())->setForegroundColor(Color::GREEN));
    }

    /**
     * @param string $message
     * @param bool   $force
     */
    public static function printError(string $message, bool $force = false)
    {
        if (static::$errorCount < 5 || $force) {
            static::printLine($message, (new Color16())->setForegroundColor(Color::RED));
        }
    }

    /**
     * @param string $message
     */
    public static function printDebug(string $message)
    {
        static::printLine($message, (new Color16())->setForegroundColor(Color::BLACK, true));
    }

    /**
     * @param string $message
     */
    public static function printHeader(string $message)
    {
        $bar     = str_pad('', \strlen($message) + 4, '=');
        $message = "$bar\n| $message |\n$bar";
        static::printLine($message, (new Color16())->setForegroundColor(Color::YELLOW));
    }

    /**
     * Prints a 16 color rainbow colored text
     *
     * @param string $message
     * @param bool   $useBackColors
     * @param array  $flags
     * @param bool   $lineBreak
     */
    public static function printRainbow(string $message, bool $useBackColors = false, array $flags = [], $lineBreak = false)
    {
        static::ensureGenerator();
        static::print(static::$generator->genRainbow($message, $useBackColors, $flags), $lineBreak);
    }

    /**
     * Prints a 256 color rainbow colored text
     *
     * @param string $message
     * @param bool   $useBackColors
     * @param array  $flags
     * @param bool   $lineBreak
     */
    public static function printRainbow256(string $message, bool $useBackColors = false, array $flags = [], $lineBreak = false)
    {
        static::ensureGenerator();
        static::print(static::$generator->genRainbow256($message, $useBackColors, $flags), $lineBreak);
    }

    /**
     * @param array      $error_messages
     * @param array|null $debug_messages
     * @param array|null $backtrace
     */
    public static function dieWithTrace(array $error_messages, array $debug_messages = null, array $backtrace = null)
    {
        static::printErrorWithTrace($error_messages, $debug_messages, $backtrace);
        exit(1);
    }

    /**
     * @param array      $error_messages
     * @param array|null $debug_messages
     * @param array|null $backtrace
     */
    public static function printErrorWithTrace(array $error_messages, array $debug_messages = null, array $backtrace = null)
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
