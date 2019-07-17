# Console

## What is it?

This library is a console helper.
If you have a console that is not Windows command prompt,
and you can have color in your console,
this library will help you jazz up your PHP console applications.

## Installation

The best way to install this console helper is to use Composer.
~~~
composer require lupecode/console
~~~

## How To

#### tl;dr
See /tests/test.php

### Basic Print

~~~
Console::print('Hello World'); // Will not print a new line at the end
Console::printLine('Hello World'); // Will print a new line at the end
~~~

### Built-in Styles

Console has a few built-in styles

~~~
Console::printHeader('Header Message'); // Prints the text in a yellow box
Console::printDebug('Debug Message'); // Prints the text in a gray color
Console::printError('Error Message'); // Prints the text in a red color
Console::printStatus('Status Message'); // Prints the text in a blue color
Console::printSuccess('Success Message'); // Prints the text in a green color
~~~

###
