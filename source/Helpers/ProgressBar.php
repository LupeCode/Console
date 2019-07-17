<?php

namespace LupeCode\Console\Helpers;

class ProgressBar
{

    protected $timeStart;
    protected $total          = 0;
    protected $current        = 0;
    protected $barSize        = 30;
    protected $barForeColor   = Color::DEFAULT;
    protected $barBackColor   = Color::DEFAULT;
    protected $rainbowMode    = false;
    protected $rainbow256Mode = false;
    protected $generator;
    protected $showing        = false;
    protected $text           = '';
    protected $templateText   = ' $1% $2/$3 remaining: $4 sec. elapsed: $5 sec.    $6';

    /**
     * @return $this
     */
    public function reset()
    {
        $this->barSize        = 30;
        $this->barForeColor   = Color::DEFAULT;
        $this->barBackColor   = Color::DEFAULT;
        $this->rainbowMode    = false;
        $this->rainbow256Mode = false;
        $this->current        = 0;
        $this->total          = 0;
        $this->text           = '';
        $this->templateText   = ' $1% $2/$3 remaining: $4 sec. elapsed: $5 sec.    $6';

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
        if ($this->rainbow256Mode) {
            $this->rainbowMode = true;
        }

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
     * The default text is ' $1% $2/$3 remaining: $4 sec. elapsed: $5 sec.    $6'
     * $1 is the percent; $2 is the current progress; $3 is the total;
     * $4 is the estimated time remaining; $5 is the elapsed time; $6 is the post-text (set in setText())
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
            print("\e[G\e[K");
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
        if ($this->rainbowMode) {
            if ($this->rainbow256Mode) {
                $theBar = $this->generator->genRainbow256($theBar);
            } else {
                $theBar = $this->generator->genRainbow($theBar);
            }
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
        $now     = time();
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
        $left    = $this->total - $this->current;
        $eta     = round($rate * $left, 2);
        $elapsed = $now - $this->timeStart;

        $statusText = str_replace(
            ['$1', '$2', '$3', '$4', '$5', '$6'],
            [$display, $this->current, $this->total, number_format($eta), number_format($elapsed), $this->text],
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
