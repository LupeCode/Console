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

    const VERTICAL_BORDER_CHAR   = '|';
    const HORIZONTAL_BORDER_CHAR = '-';

    protected function calculateColumnWidth(int $colNum)
    {
        $maxLength = strlen($this->headers[$colNum]);
        for ($iteratorRows = 0; $iteratorRows < $this->numRows; $iteratorRows++) {
            $maxLength = max($maxLength, strlen($this->tableData[$iteratorRows][$colNum]));
        }

        return $maxLength;
    }

    public function addColumn(string $title, int $maxWidth = 0)
    {
        $this->headers[$this->numCols]    = $title;
        $this->maxLengths[$this->numCols] = $maxWidth;
        $this->numCols++;

        return $this;
    }

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

    public function printHorizontalBorder()
    {
        echo str_pad('', $this->totalTableWidth, static::HORIZONTAL_BORDER_CHAR) . PHP_EOL;

        return $this;
    }

    public function printRow(array $row)
    {
        $lBorder = '| ';
        $rBorder = ' |' . PHP_EOL;
        $mBorder = ' | ';
        $rowData = [];
        for ($iteratorColumns = 0; $iteratorColumns < $this->numCols; $iteratorColumns++) {
            $cellOut   = substr(str_pad($row[$iteratorColumns], $this->maxLengths[$iteratorColumns]), 0, $this->maxLengths[$iteratorColumns]);
            $rowData[] = $cellOut;
        }
        echo $lBorder . implode($mBorder, $rowData) . $rBorder;
        $this->printHorizontalBorder();

        return $this;
    }

    public function printTable()
    {
        $this
            ->recalculateWidths()
            ->printHorizontalBorder()
            ->printRow($this->headers)
        ;
        for ($iteratorRows = 0; $iteratorRows < $this->numRows; $iteratorRows++) {
            $this->printRow($this->tableData[$iteratorRows]);
        }

        return $this;
    }

}
