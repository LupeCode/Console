<?php

namespace LupeCode\Console\Helpers;

/**
 * Class Color256
 *
 * @package LupeCode\Console\Helpers
 */
class Color256 extends Color16
{

    /**
     * @param string|array $color
     * @param bool   $light
     *
     * @return $this|\LupeCode\Console\Helpers\Color16
     */
    public function setBackgroundColor($color, bool $light = false)
    {
        if (\is_array($color)) {
            $this->setBackgroundColorRGB($color[0], $color[1], $color[2]);
        } else {
            parent::setBackgroundColor($color, $light);
        }

        return $this;
    }

    /**
     * @param string|array $color
     * @param bool   $light
     *
     * @return $this|\LupeCode\Console\Helpers\Color16
     */
    public function setForegroundColor($color, bool $light = false)
    {
        if (\is_array($color)) {
            $this->setForegroundColorRGB($color[0], $color[1], $color[2]);
        } else {
            parent::setForegroundColor($color, $light);
        }

        return $this;
    }

    /**
     * @param int $red
     * @param int $green
     * @param int $blue
     *
     * @return $this
     */
    public function setBackgroundColorRGB(int $red, int $green, int $blue)
    {
        $this->backColor = '48;5;' . $this->rgbToColorCode($red, $green, $blue);

        return $this;
    }

    /**
     * @param int $red
     * @param int $green
     * @param int $blue
     *
     * @return float|int
     */
    protected function rgbToColorCode(int $red, int $green, int $blue)
    {
        return 16 + $this->clamp($red, 0, 5) * 36 + $this->clamp($green, 0, 5) * 6 + $this->clamp($blue, 0, 5);
    }

    /**
     * @param int $num
     * @param int $min
     * @param int $max
     *
     * @return int
     */
    protected function clamp(int $num, int $min, int $max)
    {
        if ($num < $min) {
            return $min;
        }
        if ($num > $max) {
            return $max;
        }

        return $num;
    }

    /**
     * @param int $red
     * @param int $green
     * @param int $blue
     *
     * @return $this
     */
    public function setForegroundColorRGB(int $red, int $green, int $blue)
    {
        $this->foreColor = '38;5;' . $this->rgbToColorCode($red, $green, $blue);

        return $this;
    }

    /**
     * @param int $level
     *
     * @return $this
     */
    public function setForegroundColorGrayscale(int $level)
    {
        $this->foreColor = '38;5;' . (232 + $this->clamp($level, 0, 23));

        return $this;
    }

    /**
     * @param int $level
     *
     * @return $this
     */
    public function setBackgroundColorGrayscale(int $level)
    {
        $this->backColor = '48;5;' . (232 + $this->clamp($level, 0, 23));

        return $this;
    }
}
