<?php

namespace LupeCode\Console\Helpers;

use RuntimeException;

class Table
{
    /** @var int */
    protected $numRows = 0;
    /** @var int */
    protected $numCols = 0;
    /** @var string[][] */
    protected $tableData = [];
    /** @var string[] */
    protected $headers = [];
    /** @var array int[] */
    protected $maxLengths = [];
    /** @var int */
    protected $totalTableWidth = 0;
    /** @var bool */
    protected $outerHorizontalBorder = true;
    /** @var bool */
    protected $innerHorizontalBorder = true;
    /** @var bool */
    protected $outerVerticalBorder = true;
    /** @var bool */
    protected $innerVerticalBorder = true;

    const VERTICAL_BORDER_CHAR   = '|';
    const HORIZONTAL_BORDER_CHAR = '-';

    /**
     * @param array $maxLengths
     *
     * @return $this
     */
    public function setMaxLengths(array $maxLengths)
    {
        $this->maxLengths = $maxLengths;

        return $this;
    }

    /**
     * @param int $index
     * @param int $maxLength
     *
     * @return $this
     */
    public function setMaxLength(int $index, int $maxLength)
    {
        $this->maxLengths[$index] = $maxLength;

        return $this;
    }

    /**
     * @param bool $outerHorizontalBorder
     *
     * @return $this
     */
    public function setOuterHorizontalBorder(bool $outerHorizontalBorder)
    {
        $this->outerHorizontalBorder = $outerHorizontalBorder;

        return $this;
    }

    /**
     * @param bool $innerHorizontalBorder
     *
     * @return $this
     */
    public function setInnerHorizontalBorder(bool $innerHorizontalBorder)
    {
        $this->innerHorizontalBorder = $innerHorizontalBorder;

        return $this;
    }

    /**
     * @param bool $outerVerticalBorder
     *
     * @return $this
     */
    public function setOuterVerticalBorder(bool $outerVerticalBorder)
    {
        $this->outerVerticalBorder = $outerVerticalBorder;

        return $this;
    }

    /**
     * @param bool $innerVerticalBorder
     *
     * @return $this
     */
    public function setInnerVerticalBorder(bool $innerVerticalBorder)
    {
        $this->innerVerticalBorder = $innerVerticalBorder;

        return $this;
    }

    /**
     * @param bool $innerBorder
     *
     * @return $this
     */
    public function setInnerBorders(bool $innerBorder)
    {
        return $this->setInnerHorizontalBorder($innerBorder)->setInnerVerticalBorder($innerBorder);
    }

    /**
     * @param bool $outerBorder
     *
     * @return $this
     */
    public function setOuterBorders(bool $outerBorder)
    {
        return $this->setOuterHorizontalBorder($outerBorder)->setOuterVerticalBorder($outerBorder);
    }

    /**
     * @param bool $horizontalBorder
     *
     * @return $this
     */
    public function setHorizontalBorders(bool $horizontalBorder)
    {
        return $this->setInnerHorizontalBorder($horizontalBorder)->setOuterHorizontalBorder($horizontalBorder);
    }

    /**
     * @param bool $verticalBorder
     *
     * @return $this
     */
    public function setVerticalBorders(bool $verticalBorder)
    {
        return $this->setInnerVerticalBorder($verticalBorder)->setOuterVerticalBorder($verticalBorder);
    }

    /**
     * @param bool $border
     *
     * @return $this
     */
    public function setBorders(bool $border)
    {
        return $this->setOuterBorders($border)->setInnerBorders($border);
    }

    /**
     * @param int $colNum
     *
     * @return int
     */
    protected function calculateColumnWidth(int $colNum)
    {
        $maxLength = strlen($this->headers[$colNum]);
        for ($iteratorRows = 0; $iteratorRows < $this->numRows; $iteratorRows++) {
            $maxLength = max($maxLength, strlen($this->tableData[$iteratorRows][$colNum]));
        }

        return $maxLength;
    }

    /**
     * @param string $title
     * @param int    $maxWidth
     *
     * @return $this
     */
    public function addColumn(string $title, int $maxWidth = 0)
    {
        $this->headers[$this->numCols]    = $title;
        $this->maxLengths[$this->numCols] = $maxWidth;
        $this->numCols++;

        return $this;
    }

    /**
     * @param array $row
     *
     * @return $this
     */
    public function addRow(array $row)
    {
        $newRow = [];
        for ($iteratorColumns = 0; $iteratorColumns < $this->numCols; $iteratorColumns++) {
            $toConsider = $row[$iteratorColumns];
            if (!is_scalar($toConsider) && !(is_object($toConsider) && method_exists($toConsider, '__toString'))) {
                throw new RuntimeException("Cannot make a string out of this.");
            }
            $newRow[] = (string)$toConsider;
        }
        $this->tableData[] = $newRow;
        $this->numRows++;

        return $this;
    }

    /**
     * @return $this
     */
    public function recalculateWidths()
    {
        for ($iteratorColumns = 0; $iteratorColumns < $this->numCols; $iteratorColumns++) {
            if (empty($this->maxLengths[$iteratorColumns])) {
                $this->maxLengths[$iteratorColumns] = $this->calculateColumnWidth($iteratorColumns);
            }
        }
        $this->totalTableWidth = array_sum($this->maxLengths) + count($this->maxLengths) * 3 + 1;

        return $this;
    }

    /**
     * @return $this
     */
    public function printHorizontalBorder()
    {
        echo str_pad('', $this->totalTableWidth, static::HORIZONTAL_BORDER_CHAR) . PHP_EOL;

        return $this;
    }

    /**
     * @param array $row
     *
     * @return $this
     */
    public function printRow(array $row)
    {
        if ($this->outerVerticalBorder) {
            $lBorder = self::VERTICAL_BORDER_CHAR . ' ';
            $rBorder = ' ' . self::VERTICAL_BORDER_CHAR . PHP_EOL;
        } else {
            $lBorder = ' ';
            $rBorder = ' ' . PHP_EOL;
        }
        if ($this->innerVerticalBorder) {
            $mBorder = ' ' . self::VERTICAL_BORDER_CHAR . ' ';
        } else {
            $mBorder = '  ';
        }
        $rowData = [];
        for ($iteratorColumns = 0; $iteratorColumns < $this->numCols; $iteratorColumns++) {
            if (($this->maxLengths[$iteratorColumns] > 0) && strlen($row[$iteratorColumns]) > $this->maxLengths[$iteratorColumns]) {
                $cellOut = substr($row[$iteratorColumns], 0, $this->maxLengths[$iteratorColumns] - 3) . '...';
            } else {
                $cellOut = str_pad($row[$iteratorColumns], $this->maxLengths[$iteratorColumns]);
            }
            $rowData[] = $cellOut;
        }
        echo $lBorder . implode($mBorder, $rowData) . $rBorder;

        return $this;
    }

    /**
     * @return $this
     */
    public function printTable()
    {
        $this->recalculateWidths();
        if ($this->outerHorizontalBorder) {
            $this->printHorizontalBorder();
        }
        $this->printRow($this->headers);

        for ($iteratorRows = 0; $iteratorRows < $this->numRows; $iteratorRows++) {
            if ($this->innerHorizontalBorder) {
                $this->printHorizontalBorder();
            }
            $this->printRow($this->tableData[$iteratorRows]);
        }

        if ($this->outerHorizontalBorder) {
            $this->printHorizontalBorder();
        }

        return $this;
    }

}
