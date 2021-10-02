<?php /** @noinspection PhpUnhandledExceptionInspection */

require __DIR__ . '/../vendor/autoload.php';

use Jawira\MiniGetopt\MiniGetopt;

// Setup
$mg = new MiniGetopt();
$mg->addRequired('r', 'required', 'This is a required option');
$mg->addOptional('o', 'optional', 'This is an optional option');
$mg->addNoValue('n', 'novalue', 'This has no value');

$examples = ['test -r=demo',
             'test --optional --novalue',
             'test -n',];

echo $mg->doc('', $examples);
echo str_repeat('*', 20) . PHP_EOL;
echo $mg->doc('This is a test command.');
echo str_repeat('*', 20) . PHP_EOL;
echo $mg->doc();
