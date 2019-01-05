<?php

namespace LupeCode\Console\Helpers;

class Color16 implements Color
{

    protected $foreColor = "39";
    protected $backColor = "49";
    protected $flags     = "";
    protected $foreLight = false;
    protected $backLight = false;

    public function reset()
    {
        $this->foreColor = "39";
        $this->backColor = "49";
        $this->flags     = "";
        $this->foreLight = false;
        $this->backLight = false;

        return $this;
    }

    public function getColorCode()
    {
        return implode(";", [$this->flags, $this->backColor, $this->foreColor,]);
    }

    public function getEscapeSequence()
    {
        return "\e[" . $this->getColorCode() . "m";
    }

    public function setForegroundColor(string $color, bool $light = false)
    {
        if ($light) {
            $this->foreColor = "9" . $color;
        } else {
            $this->foreColor = "3" . $color;
        }

        return $this;
    }

    public function setBackgroundColor(string $color, bool $light = false)
    {
        if ($light) {
            $this->backColor = "10" . $color;
        } else {
            $this->backColor = "4" . $color;
        }

        return $this;
    }

    public function clearFlags()
    {
        $this->flags = "";

        return $this;
    }

    public function setFlag(string $flag, bool $off = false)
    {
        if (!empty($this->flags)) {
            $this->flags .= ";";
        }
        if ($off) {
            $this->flags .= "2";
        }
        $this->flags .= $flag;

        return $this;
    }
}
