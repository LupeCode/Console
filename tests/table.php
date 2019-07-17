<?php

use LupeCode\Console\Console;

require_once __DIR__ . '/../vendor/autoload.php';

tableTest();

function tableTest()
{
    Console::table()
           ->addColumn('ID')
           ->addColumn('Title', 35)
           ->addColumn('ISBN')
           ->addRow([1, 'Lorem Ipsum and the Valley of Goblins', '987-12345678-1'])
           ->addRow([2, 'Lorem Ipsum and the Chair of Sadness', '987-12345678-2'])
           ->addRow([3, 'Lorem Ipsum and the Sands of Itchiness', '987-12345678-3'])
           ->addRow([4, 'Lorem Ipsum and the Lingua Franca', '987-12345678-4'])
           ->printTable()
    ;
}
