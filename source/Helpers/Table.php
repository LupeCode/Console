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

    public function printTable()
    {
        for ($iteratorColumns = 0; $iteratorColumns < $this->numCols; $iteratorColumns++) {
            if (empty($this->maxLengths[$iteratorColumns])) {
                $this->maxLengths[$iteratorColumns] = $this->calculateColumnWidth($iteratorColumns);
            }
        }
        $totalTableWidth = array_sum($this->maxLengths) + count($this->maxLengths) * 3 + 1;
        $vBorder = str_pad('', $totalTableWidth, '-') . PHP_EOL;
        $lBorder = '| ';
        $rBorder = ' |' . PHP_EOL;
        $mBorder = ' | ';
        echo $vBorder;
        $headOut = [];
        for ($iteratorColumns = 0; $iteratorColumns < $this->numCols; $iteratorColumns++) {
            $headOut[] = substr(str_pad($this->headers[$iteratorColumns], $this->maxLengths[$iteratorColumns]), 0, $this->maxLengths[$iteratorColumns]);
        }
        echo $lBorder . implode($mBorder, $headOut) . $rBorder;
        echo $vBorder;
        for ($iteratorRows = 0; $iteratorRows < $this->numRows; $iteratorRows++) {
            $rowData = [];
            for ($iteratorColumns = 0; $iteratorColumns < $this->numCols; $iteratorColumns++) {
                $cellOut = substr(str_pad($this->tableData[$iteratorRows][$iteratorColumns], $this->maxLengths[$iteratorColumns]), 0, $this->maxLengths[$iteratorColumns]);
                $rowData[] = $cellOut;
            }
            echo $lBorder . implode($mBorder, $rowData) . $rBorder;
            echo $vBorder;
        }

        return $this;
    }

}
