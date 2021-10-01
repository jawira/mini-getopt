<?php /** @noinspection PhpUnhandledExceptionInspection */

require __DIR__ . '/../vendor/autoload.php';

use Jawira\MiniGetopt\MiniGetopt;

// Setup
$mg = new MiniGetopt();
$mg->addRequired('r', 'required', 'This is a required option');
$mg->addOptional('o', 'optional', 'This is an optional option');
$mg->addNoValue('n', 'novalue', 'This has no value');

echo $mg->doc('This is a test command');
