<?php

namespace LupeCode\Console\Helpers;

class ProgressBar
{
    /** @var int */
    protected $timeStart;
    /** @var int */
    protected $total = 0;
    /** @var int */
    protected $current = 0;
    /** @var int */
    protected $barSize = 30;
    /** @var string */
    protected $barForeColor = Color::DEFAULT;
    /** @var string */
    protected $barBackColor = Color::DEFAULT;
    /** @var bool */
    protected $rainbowMode = false;
    /** @var bool */
    protected $rainbow256Mode = false;
    /** @var \LupeCode\Console\Helpers\Generator */
    protected $generator;
    /** @var bool */
    protected $showing = false;
    /** @var string */
    protected $text = '';
    /** @var string */
    protected $templateText = ' $1% $2/$3 remaining: $4 sec. elapsed: $5 sec. $7 per sec.    $6';

    /**
     * @return $this
     */
    public function reset()
    {
        $this->current        = 0;
        $this->total          = 0;
        $this->barSize        = 30;
        $this->barForeColor   = Color::DEFAULT;
        $this->barBackColor   = Color::DEFAULT;
        $this->rainbowMode    = false;
        $this->rainbow256Mode = false;
        $this->showing        = false;
        $this->text           = '';
        $this->templateText   = ' $1% $2/$3 remaining: $4 sec. elapsed: $5 sec. $7 per sec.    $6';

        return $this->startTimer();
    }

    /**
     * @param string $barForeColor
     *
     * @return $this
     */
    public function setBarForeColor(string $barForeColor)
    {
        $this->barForeColor = $barForeColor;

        return $this;
    }

    /**
     * @param string $barBackColor
     *
     * @return $this
     */
    public function setBarBackColor(string $barBackColor)
    {
        $this->barBackColor = $barBackColor;

        return $this;
    }

    /**
     * @param bool $rainbowMode
     *
     * @return $this
     */
    public function setRainbowMode(bool $rainbowMode)
    {
        $this->rainbowMode = $rainbowMode;

        return $this;
    }

    /**
     * @param bool $rainbow256Mode
     *
     * @return $this
     */
    public function setRainbow256Mode(bool $rainbow256Mode)
    {
        $this->rainbow256Mode = $rainbow256Mode;

        return $this;
    }

    /**
     * @param int $size
     *
     * @return $this
     */
    public function setBarSize(int $size)
    {
        $this->barSize = $size;

        return $this;
    }

    /**
     * @param int $total
     *
     * @return $this
     */
    public function setTotal(int $total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @param int $current
     *
     * @return $this
     */
    public function setCurrent(int $current)
    {
        $this->current = $current;

        return $this->update();
    }

    /**
     * @return $this
     */
    public function startTimer()
    {
        $this->timeStart = time();

        return $this;
    }

    /**
     * @param string $text
     * The default text is ' $1% $2/$3 remaining: $4 sec. elapsed: $5 sec. $7 per sec.    $6'
     * $1 is the percent;
     * $2 is the current progress;
     * $3 is the total;
     * $4 is the estimated time remaining;
     * $5 is the elapsed time;
     * $6 is the post-text (set in setText())
     * $7 is the speed;
     *
     * @return $this
     */
    public function setProgressText(string $text)
    {
        $this->templateText = $text;

        return $this;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return bool
     */
    public function isShowing()
    {
        return $this->showing;
    }

    /**
     * ProgressBar constructor.
     */
    public function __construct()
    {
        $this->generator = new Generator();
    }

    /**
     * @return $this
     */
    public function increment()
    {
        return $this->adjust(1);
    }

    /**
     * @param int $amount
     *
     * @return $this
     */
    public function adjust(int $amount)
    {
        $this->current += $amount;
        if ($this->current < 0) {
            $this->current = 0;
        }

        return $this->update();
    }

    /**
     * @return $this
     */
    public function clear()
    {
        if ($this->showing) {
            print("\e[G\e[2K");
            $this->showing = false;
        }
        flush();

        return $this;
    }

    /**
     * @return $this
     */
    public function printBar()
    {
        if ($this->total > 0) {
            $percent = (double)($this->current / $this->total);
        } else {
            $percent = .0;
        }
        $bar    = floor($percent * $this->barSize);
        $theBar = str_repeat('=', $bar);
        if ($bar < $this->barSize) {
            $theBar .= '>';
        } else {
            $theBar .= '=';
        }
        if ($this->rainbow256Mode) {
            $theBar = $this->generator->genRainbow256($theBar);
        } elseif ($this->rainbowMode) {
            $theBar = $this->generator->genRainbow($theBar);
        } else {
            $theBar = (new Color256())->setBackgroundColor($this->barBackColor)->setForegroundColor($this->barForeColor)->getEscapeSequence() . $theBar . "\e[0m";
        }
        $this->clear();
        echo '[' . $theBar . str_repeat(' ', $this->barSize - $bar) . ']';
        $this->showing = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function printText()
    {
        $now = time();
        if ($this->total > 0) {
            $percent = (double)($this->current / $this->total);
        } else {
            $percent = .0;
        }
        $display = number_format($percent * 100, 0);
        if ($this->current > 0) {
            $rate = ($now - $this->timeStart) / $this->current;
        } else {
            $rate = 0;
        }
        $speed   = round($rate / 1, 2);
        $left    = $this->total - $this->current;
        $eta     = round($rate * $left, 2);
        $elapsed = $now - $this->timeStart;

        $statusText = str_replace(
            ['$1', '$2', '$3', '$4', '$5', '$6', '$7'],
            [$display, $this->current, $this->total, number_format($eta), number_format($elapsed), $this->text, $speed],
            $this->templateText
        );
        echo $statusText;

        return $this;
    }

    /**
     * @return $this
     */
    public function update()
    {
        $this->printBar()->printText();

        return $this;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function finish(string $message = '')
    {
        $this->showing = false;
        echo $message . PHP_EOL;

        return $this->reset();
    }

}
