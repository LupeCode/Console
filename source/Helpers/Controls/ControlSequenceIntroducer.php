<?php

namespace LupeCode\Console\Helpers\Controls;

/**
 * Class ControlSequenceIntroducer
 *
 * @package LupeCode\Console\Helpers\Controls
 * @site https://en.wikipedia.org/wiki/ANSI_escape_code#CSI_sequences
 */
class ControlSequenceIntroducer
{
    public static function CSI() { return "\e["; }

    /**
     * Switch to the alternate screen buffer
     *
     * @return string
     */
    public static function ALT_BUFF_ON() { return self::CSI() . "?1049h"; }

    /**
     * Switch to the main screen buffer
     *
     * @return string
     */
    public static function ALT_BUFF_OFF() { return self::CSI() . "?1049l"; }

    /**
     * Cursor Up
     * Moves the cursor n (default 1) cells in the given direction. If the cursor is already at the edge of the screen, this has no effect.
     *
     * @param int $n
     *
     * @return string
     */
    public static function CUU(int $n = 1) { return self::CSI() . $n . "A"; }

    /**
     * Cursor Down
     * Moves the cursor n (default 1) cells in the given direction. If the cursor is already at the edge of the screen, this has no effect.
     *
     * @param int $n
     *
     * @return string
     */
    public static function CUD(int $n = 1) { return self::CSI() . $n . "B"; }

    /**
     * Cursor Forward
     * Moves the cursor n (default 1) cells in the given direction. If the cursor is already at the edge of the screen, this has no effect.
     *
     * @param int $n
     *
     * @return string
     */
    public static function CUF(int $n = 1) { return self::CSI() . $n . "C"; }

    /**
     * Cursor Back
     * Moves the cursor n (default 1) cells in the given direction. If the cursor is already at the edge of the screen, this has no effect.
     *
     * @param int $n
     *
     * @return string
     */
    public static function CUB(int $n = 1) { return self::CSI() . $n . "D"; }

    /**
     * Cursor Next Line
     * Moves cursor to beginning of the line n (default 1) lines down. (not ANSI.SYS)
     *
     * @param int $n
     *
     * @return string
     */
    public static function CNL(int $n = 1) { return self::CSI() . $n . "E"; }

    /**
     * Cursor Previous Line
     * Moves cursor to beginning of the line n (default 1) lines up. (not ANSI.SYS)
     *
     * @param int $n
     *
     * @return string
     */
    public static function CPL(int $n = 1) { return self::CSI() . $n . "F"; }

    /* CSI n G         CHA     Cursor Horizontal Absolute      Moves the cursor to column n (default 1). (not ANSI.SYS) */
    /**
     * Cursor Horizontal Absolute
     * Moves the cursor to column n (default 1). (not ANSI.SYS)
     *
     * @param int $n
     *
     * @return string
     */
    public static function CHA(int $n = 1) { return self::CSI() . $n . "G"; }

    /**
     * Cursor Position
     * Moves the cursor to row n, column m. The values are 1-based, and default to 1 (top left corner) if omitted.
     * A sequence such as CSI() ;5H is a synonym for CSI() 1;5H as well as CSI() 17;H is the same as CSI() 17H and CSI() 17;1H
     *
     * @param int $n
     * @param int $m
     *
     * @return string
     */
    public static function CUP(int $n = 1, int $m = 1) { return self::CSI() . $n . ";" . $m . "H"; }

    const ED_CURSOR_TO_END                = "0";
    const ED_CURSOR_TO_BEGINNING          = "1";
    const ED_ENTIRE_SCREEN                = "2";
    const ED_ENTIRE_SCREEN_AND_SCROLLBACK = "3";

    /**
     * Erase in Display
     * Clears part of the screen.
     * If n is 0 (or missing), clear from cursor to end of screen.
     * If n is 1, clear from cursor to beginning of the screen.
     * If n is 2, clear entire screen (and moves cursor to upper left on DOS ANSI.SYS).
     * If n is 3, clear entire screen and delete all lines saved in the scrollback buffer (this feature was added for xterm and is supported by other terminal applications).
     *
     * @param int $n
     *
     * @return string
     */
    public static function ED(int $n = 0) { return self::CSI() . $n . "J"; }

    const EL_CURSOR_TO_END       = "0";
    const EL_CURSOR_TO_BEGINNING = "1";
    const EL_ENTIRE_SCREEN       = "2";

    /**
     * Erase in Line
     * Erases part of the line.
     * If n is 0 (or missing), clear from cursor to the end of the line.
     * If n is 1, clear from cursor to beginning of the line.
     * If n is 2, clear entire line.
     * Cursor position does not change.
     *
     * @param int $n
     *
     * @return string
     */
    public static function EL(int $n = 0) { return self::CSI() . $n . "K"; }

    /**
     * Scroll Up
     * Scroll whole page up by n (default 1) lines. New lines are added at the bottom. (not ANSI.SYS)
     *
     * @param int $n
     *
     * @return string
     */
    public static function SU(int $n = 0) { return self::CSI() . $n . "S"; }

    /**
     * Scroll Down
     * Scroll whole page down by n (default 1) lines. New lines are added at the top. (not ANSI.SYS)
     *
     * @param int $n
     *
     * @return string
     */
    public static function SD(int $n = 0) { return self::CSI() . $n . "T"; }

    /**
     * Horizontal Vertical Position
     * Same as CUP, but counts as a format effector function (like CR or LF) rather than an editor function (like CUD or CNL).
     * This can lead to different handling in certain terminal modes.[5]:Annex A
     *
     * @param int $n
     * @param int $m
     *
     * @return string
     */
    public static function HVP(int $n = 1, int $m = 1) { return self::CSI() . $n . ";" . $m . "f"; }

    /**
     * Select Graphic Rendition
     * Sets the appearance of the following characters, see SGR parameters below.
     *
     * @param string $n
     *
     * @return string
     */
    public static function SGR(string $n = '0') { return self::CSI() . $n . "m"; }

}
