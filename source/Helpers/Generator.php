<?php

namespace LupeCode\Console\Helpers;

class Generator
{

    protected function r256(Color256 $color, int $r, int $g, int $b, bool $useBackColors = false, array $flags = [])
    {
        $color->setForegroundColorRGB($r, $g, $b);
        if ($useBackColors) {
            $color->setBackgroundColorRGB(5 - $r, 5 - $g, 5 - $b);
        }
        foreach ($flags as $flag) {
            $color->clearFlags()->setFlag($flag);
        }

        return $color->getEscapeSequence();
    }

    public function genRainbow256(string $message, $useBackColors = false, array $flags = [])
    {
        $length   = strlen($message);
        $color    = new Color256();
        $iterator = 0;
        $output   = "";
        if (empty($flags)) {
            $flags = [Color::BOLD];
        }
        while (true) {
            for ($r = 5, $g = 0, $b = 0; $g < 6; $g++) {
                if ($iterator >= $length) {
                    return $output . "\e[0m";
                }
                $output .= $this->r256($color, $r, $g, $b, $useBackColors, $flags) . $message[$iterator++];
            }
            for ($r = 5, $g = 5, $b = 0; $r >= 0; $r--) {
                if ($iterator >= $length) {
                    return $output . "\e[0m";
                }
                $output .= $this->r256($color, $r, $g, $b, $useBackColors, $flags) . $message[$iterator++];
            }
            for ($r = 0, $g = 5, $b = 0; $b < 6; $b++) {
                if ($iterator >= $length) {
                    return $output . "\e[0m";
                }
                $output .= $this->r256($color, $r, $g, $b, $useBackColors, $flags) . $message[$iterator++];
            }
            for ($r = 0, $g = 5, $b = 5; $g >= 0; $g--) {
                if ($iterator >= $length) {
                    return $output . "\e[0m";
                }
                $output .= $this->r256($color, $r, $g, $b, $useBackColors, $flags) . $message[$iterator++];
            }
            for ($r = 0, $g = 0, $b = 5; $r < 6; $r++) {
                if ($iterator >= $length) {
                    return $output . "\e[0m";
                }
                $output .= $this->r256($color, $r, $g, $b, $useBackColors, $flags) . $message[$iterator++];
            }
            for ($r = 5, $g = 0, $b = 5; $b >= 0; $b--) {
                if ($iterator >= $length) {
                    return $output . "\e[0m";
                }
                $output .= $this->r256($color, $r, $g, $b, $useBackColors, $flags) . $message[$iterator++];
            }
        }

        return "";
    }

    /**
     * @param string $message
     * @param bool   $useBackColors
     * @param array  $flags
     *
     * @return string
     */
    public function genRainbow(string $message, bool $useBackColors = false, array $flags = [])
    {
        $foreColors = ["1", "3", "2", "6", "4", "5"];
        $backColors = ["6", "4", "5", "1", "3", "2"];
        $length     = strlen($message);
        $output     = "";
        if (empty($flags)) {
            $flags[] = Color::BOLD;
        }
        for ($iterator = 0; $iterator < $length; $iterator++) {
            $color = new Color16();
            $color->setForegroundColor($foreColors[$iterator % 6]);
            foreach ($flags as $flag) {
                $color->setFlag($flag);
            }
            if ($useBackColors) {
                $color->setBackgroundColor($backColors[$iterator % 6]);
            }
            $output .= $color->getEscapeSequence() . $message[$iterator];
        }
        $output .= "\e[0m";

        return $output;
    }

    /**
     * @param string $message
     * @param Color  $color
     *
     * @return string
     */
    public function genColor(string $message, Color $color)
    {
        return $color->getEscapeSequence() . $message . "\e[39;49;0m";
    }
}
