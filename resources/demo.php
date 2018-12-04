<?php

require __DIR__ . '/../vendor/autoload.php';

use Jawira\MiniGetopt\MiniGetopt;

// Setup
$getopt = new MiniGetopt();
$getopt->addRequired('f', 'format', 'File format'); // <1>
$getopt->addOptional('r', 'retry', 'Retry when error'); // <2>
$getopt->addNoValue('h', 'help', 'Show help'); // <3>

// Retrieving values
$format  = $getopt->getOption('f', 'format', 'png'); // <4>
$message = $getopt->getOption('r', 'retry'); // <5>
$help    = $getopt->getOption('h', 'help');

// Show retrieved values
var_dump($format, $message, $help);
