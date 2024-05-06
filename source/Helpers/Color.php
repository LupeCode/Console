<?php

namespace LupeCode\Console\Helpers;

/**
 * Interface Color
 *
 * @package LupeCode\Console\Helpers
 */
interface Color
{
    public const BLACK   = '0';
    public const RED     = '1';
    public const GREEN   = '2';
    public const YELLOW  = '3';
    public const BLUE    = '4';
    public const MAGENTA = '5';
    public const CYAN    = '6';
    public const GRAY    = '7';
    public const DEFAULT = '9';

    public const RESET      = '0';
    public const BOLD       = '1';
    public const DIM        = '2';
    public const ITALIC     = '3';
    public const UNDERLINE  = '4';
    public const BLINK      = '5';
    public const BLINK_FAST = '6';
    public const INVERT     = '7';
    public const HIDDEN     = '8';

    public function reset();

    public function getColorCode();

    public function getEscapeSequence();
}
