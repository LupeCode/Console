<?php

use LupeCode\Console\Console;

require_once __DIR__ . '/../vendor/autoload.php';

tableTest();

function tableTest()
{
    Console::printHeader('Table Test');

    Console::printStatus('The title column has a max width of 25');
    addTableData();
    Console::table()
           ->setMaxLength(1, 25)
           ->printTable()
    ;

    Console::printStatus('There are no max widths');
    addTableData();
    Console::table()
           ->printTable()
    ;

    Console::printStatus('There are no borders');
    addTableData();
    Console::table()
           ->setBorders(false)
           ->printTable()
    ;
}

function addTableData()
{
    Console::table(true)
           ->addColumn('ID')
           ->addColumn('Title')
           ->addColumn('ISBN')
           ->addRow([1, 'Lorem Ipsum and the Valley of Goblins', '987-12345678-1'])
           ->addRow([2, 'Lorem Ipsum and the Chair of Sadness', '987-12345678-2'])
           ->addRow([3, 'Lorem Ipsum and the Sands of Itchiness', '987-12345678-3'])
           ->addRow([4, 'Lorem Ipsum and the Lingua Franca', '987-12345678-4'])
    ;
}
