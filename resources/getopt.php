<?php /** @noinspection PhpUnhandledExceptionInspection */

require __DIR__ . '/../vendor/autoload.php';

use Jawira\MiniGetopt\MiniGetopt;

// Setup
$mg = new MiniGetopt();
$mg->addRequired('f', 'format', 'Format to export', 'png|gif|svg');
$mg->addOptional('r', 'retry', 'Retry on error', 'count');
$mg->addOptional('q', '', 'Quiet mode', 'yes|no');
$mg->addNoValue('v', 'verbose', 'Display verbose messages');
$mg->addNoValue('', 'version', 'Show version');

// Calling getopt function
echo var_export($mg->getopt(), true);
