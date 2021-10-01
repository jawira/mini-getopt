<?php /** @noinspection PhpUnhandledExceptionInspection */

require __DIR__ . '/../vendor/autoload.php';

use Jawira\MiniGetopt\MiniGetopt;

// Setup
$mg = new MiniGetopt();
$mg->addNoValue('f', 'foo', 'Foo option');
$mg->addNoValue('b', 'bar', 'Bar Option');
$mg->addNoValue('', 'help', 'Show help');

// Calling getopt function
$optind = null;
$mg->getopt($optind);
echo "optind: $optind" . PHP_EOL;
