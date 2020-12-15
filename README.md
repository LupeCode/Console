# Console

## What is it?

This library is a console helper for ANSI colors, progress bars, and tables.

If you have a console that is not Windows command prompt,
and you can have color in your console,
this library will help you jazz up your PHP console applications.

## Requirements

This library requires PHP >= 7.0.

### Readline

If you wish to use `Console::readline`, `Console::promptReadline`, or `Console::optionsReadline` you will need to have the readline module loaded in PHP.
On Windows, this requires PHP >= 7.1.0

## Installation

The best way to install this console helper is to use Composer.
~~~bash
composer require lupecode/console
~~~

## How To

#### tl;dr
See the tests folder.

### Basic Print

~~~php
Console::print('Hello World'); // Will not print a new line at the end
Console::printLine('Hello World'); // Will print a new line at the end
~~~

### Built-in Styles

Console has a few built-in styles.

~~~php
Console::printHeader('Header Message'); // Prints the text in a yellow box
Console::printDebug('Debug Message'); // Prints the text in a gray color
Console::printError('Error Message'); // Prints the text in a red color
Console::printStatus('Status Message'); // Prints the text in a blue color
Console::printSuccess('Success Message'); // Prints the text in a green color
~~~

### 16 Color Palette

Console has support for 16 color palette.

~~~php
$color = new Color16();
$color
    ->setBackgroundColor(Color::YELLOW)
    ->setForegroundColor(Color::BLACK)
    ->setFlag(Color::BOLD)
;
Console::printLine('Print Line In Color', $color);
~~~

### 256 Color Palette

Console has support for 256 color palette.
These colors range with RGB from 0 to 5 for 216 colors.
There are 24 levels of grayscale.

~~~php
$color = new Color256();
$color
    ->setBackgroundColor(5,5,0)
    ->setForegroundColorGrayscale(0)
    ->setFlag(Color::BOLD)
;
Console::printLine('Print Line In Color', $color);
~~~

### Progress Bars

Console has support for progress bars.

~~~php
$pBar = Console::progressBar();
$pBar->setBarSize(30)->setTotal(100)->startTimer();
for ($i = 0; $i < 100; $i++) {
    $pBar->increment();
}
$pBar->finish();
~~~

### Tables

Console has support for tables.

~~~php
Console::table()
   ->addColumn('ID')
   ->addColumn('Title')
   ->addColumn('ISBN')
   ->addRow([1, 'Lorem Ipsum and the Valley of Goblins', '987-12345678-1'])
   ->addRow([2, 'Lorem Ipsum and the Chair of Sadness', '987-12345678-2'])
   ->addRow([3, 'Lorem Ipsum and the Sands of Itchiness', '987-12345678-3'])
   ->addRow([4, 'Lorem Ipsum and the Lingua Franca', '987-12345678-4'])
   ->printTable()
;
~~~
