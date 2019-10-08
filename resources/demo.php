<?php

require __DIR__ . '/../vendor/autoload.php';

use Jawira\MiniGetopt\MiniGetopt;

// Setup
$getopt = new MiniGetopt();
$getopt->addRequired('f', 'format', 'Lorem ipsum dolor sit amet.'); // <1>
$getopt->addOptional('r', 'retry', 'Lorem ipsum dolor sit amet.'); // <2>
$getopt->addNoValue('v', 'verbose', 'Display verbose messages'); // <3>
$getopt->addNoValue('h', 'help', 'Show help'); // <3>

// Retrieving values
$format  = $getopt->getOption('f', 'format'); // <4>
$message = $getopt->getOption('r', 'retry');  // <5>
$verbose = $getopt->getOption('v', 'verbose');
$verbose = $getopt->getOption('d', null);
$version = $getopt->getOption(null, 'version');

// Show retrieved values
echo PHP_EOL . $getopt->doc() . PHP_EOL;
print_r($getopt->getopt());

