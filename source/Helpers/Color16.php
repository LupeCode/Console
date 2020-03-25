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

    protected $foreColor = '39';
    protected $backColor = '49';
    protected $flags     = '';
    protected $foreLight = false;
    protected $backLight = false;

    /**
     * @return $this
     */
    public function reset()
    {
        $this->foreColor = '39';
        $this->backColor = '49';
        $this->flags     = '';
        $this->foreLight = false;
        $this->backLight = false;

        return $this;
    }

    /**
     * @return string
     */
    public function getColorCode()
    {
        return implode(';', [$this->flags, $this->backColor, $this->foreColor]);
    }

    /**
     * @return string
     */
    public function getEscapeSequence()
    {
        return CSI::SGR($this->getColorCode());
    }

    /**
     * @param string $color
     * @param bool   $light
     *
     * @return $this
     */
    public function setForegroundColor(string $color, bool $light = false)
    {
        if ($light) {
            $this->foreColor = '9' . $color;
        } else {
            $this->foreColor = '3' . $color;
        }

        return $this;
    }

    /**
     * @param string $color
     * @param bool   $light
     *
     * @return $this
     */
    public function setBackgroundColor(string $color, bool $light = false)
    {
        if ($light) {
            $this->backColor = '10' . $color;
        } else {
            $this->backColor = '4' . $color;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearFlags()
    {
        $this->flags = '';

        return $this;
    }

    /**
     * @param string $flag
     * @param bool   $off
     *
     * @return $this
     */
    public function setFlag(string $flag, bool $off = false)
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
