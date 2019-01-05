<?php

namespace LupeCode\Console\Helpers;

interface Color
{
    const BLACK   = "0";
    const RED     = "1";
    const GREEN   = "2";
    const YELLOW  = "3";
    const BLUE    = "4";
    const MAGENTA = "5";
    const CYAN    = "6";
    const GRAY    = "7";
    const DEFAULT = "9";

    const BOLD       = "1";
    const DIM        = "2";
    const ITALIC     = "3";
    const UNDERLINE  = "4";
    const BLINK      = "5";
    const BLINK_FAST = "6";
    const INVERT     = "7";
    const HIDDEN     = "8";

    public function reset();

    public function getColorCode();

    public function getEscapeSequence();
}
