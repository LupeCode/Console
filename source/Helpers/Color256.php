<?php

namespace LupeCode\Console\Helpers;

/**
 * Class Color256
 *
 * @package LupeCode\Console\Helpers
 */
class Color256 extends Color16
{


    public function setBackgroundColor(array | string $color, bool $light = false): static
    {
        if (is_array($color)) {
            $this->setBackgroundColorRGB($color[0], $color[1], $color[2]);
        } else {
            parent::setBackgroundColor($color, $light);
        }

        return $this;
    }

    public function setForegroundColor(array | string $color, bool $light = false): static
    {
        if (is_array($color)) {
            $this->setForegroundColorRGB($color[0], $color[1], $color[2]);
        } else {
            parent::setForegroundColor($color, $light);
        }

        return $this;
    }

    public function setBackgroundColorRGB(int $red, int $green, int $blue): static
    {
        $this->backColor = '48;5;' . $this->rgbToColorCode($red, $green, $blue);

        return $this;
    }

    protected function rgbToColorCode(int $red, int $green, int $blue): int
    {
        return 16 + $this->clamp($red, 0, 5) * 36 + $this->clamp($green, 0, 5) * 6 + $this->clamp($blue, 0, 5);
    }

    protected function clamp(int $num, int $min, int $max): int
    {
        if ($num < $min) {
            return $min;
        }
        if ($num > $max) {
            return $max;
        }

        return $num;
    }

    public function setForegroundColorRGB(int $red, int $green, int $blue): static
    {
        $this->foreColor = '38;5;' . $this->rgbToColorCode($red, $green, $blue);

        return $this;
    }

    public function setForegroundColorGrayscale(int $level): static
    {
        $this->foreColor = '38;5;' . (232 + $this->clamp($level, 0, 23));

        return $this;
    }

    public function setBackgroundColorGrayscale(int $level): static
    {
        $this->backColor = '48;5;' . (232 + $this->clamp($level, 0, 23));

        return $this;
    }
}
