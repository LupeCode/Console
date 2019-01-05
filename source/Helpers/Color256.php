<?php

namespace LupeCode\Console\Helpers;

class Color256 extends Color16
{

    public function setBackgroundColor($color, bool $light = false)
    {
        if (is_array($color)) {
            $this->setBackgroundColorRGB($color[0], $color[1], $color[2]);
        } else {
            parent::setBackgroundColor($color, $light);
        }

        return $this;
    }

    public function setForegroundColor($color, bool $light = false)
    {
        if (is_array($color)) {
            $this->setForegroundColorRGB($color[0], $color[1], $color[2]);
        } else {
            parent::setForegroundColor($color, $light);
        }

        return $this;
    }

    public function setBackgroundColorRGB(int $red, int $green, int $blue)
    {
        $this->backColor = "48;5;" . $this->rgbToColorCode($red, $green, $blue);

        return $this;
    }

    protected function rgbToColorCode(int $red, int $green, int $blue)
    {
        return 16 + $this->clamp($red, 0, 5) * 36 + $this->clamp($green, 0, 5) * 6 + $this->clamp($blue, 0, 5);
    }

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

    public function setForegroundColorRGB(int $red, int $green, int $blue)
    {
        $this->foreColor = "38;5;" . $this->rgbToColorCode($red, $green, $blue);

        return $this;
    }

    public function setForegroundColorGrayscale(int $level)
    {
        $this->foreColor = "38;5;" . (232 + $this->clamp($level, 0, 23));

        return $this;
    }

    public function setBackgroundColorGrayscale(int $level)
    {
        $this->backColor = "48;5;" . (232 + $this->clamp($level, 0, 23));

        return $this;
    }
}
