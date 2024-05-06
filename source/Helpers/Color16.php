<?php

namespace LupeCode\Console\Helpers;

use LupeCode\Console\Helpers\Controls\ControlSequenceIntroducer as CSI;

/**
 * Class Color16
 *
 * @package LupeCode\Console\Helpers
 */
class Color16 implements Color
{

    protected string $foreColor = '39';
    protected string $backColor = '49';
    protected string $flags     = '';
    protected bool $foreLight = false;
    protected bool $backLight = false;

    public function reset(): static
    {
        $this->foreColor = '39';
        $this->backColor = '49';
        $this->flags     = '';
        $this->foreLight = false;
        $this->backLight = false;

        return $this;
    }

    public function getColorCode(): string
    {
        return implode(';', [$this->flags, $this->backColor, $this->foreColor]);
    }

    public function getEscapeSequence(): string
    {
        return CSI::SGR($this->getColorCode());
    }

    public function setForegroundColor(string $color, bool $light = false): static
    {
        if ($light) {
            $this->foreColor = '9' . $color;
        } else {
            $this->foreColor = '3' . $color;
        }

        return $this;
    }

    public function setBackgroundColor(string $color, bool $light = false): static
    {
        if ($light) {
            $this->backColor = '10' . $color;
        } else {
            $this->backColor = '4' . $color;
        }

        return $this;
    }

    public function clearFlags(): static
    {
        $this->flags = '';

        return $this;
    }

    public function setFlag(string $flag, bool $off = false): static
    {
        if (!empty($this->flags)) {
            $this->flags .= ';';
        }
        if ($off) {
            $this->flags .= '2';
        }
        $this->flags .= $flag;

        return $this;
    }
}
