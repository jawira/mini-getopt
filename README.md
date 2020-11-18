Mini Getopt (a getopt wrapper)
==============================

Very simple wrapper for `getopt()` function.

[![Latest Stable Version](https://poser.pugx.org/jawira/mini-getopt/v)](//packagist.org/packages/jawira/mini-getopt)
[![composer.lock](https://poser.pugx.org/jawira/mini-getopt/composerlock)](//packagist.org/packages/jawira/mini-getopt)
[![.gitattributes](https://poser.pugx.org/jawira/mini-getopt/gitattributes)](//packagist.org/packages/jawira/mini-getopt)
[![License](https://poser.pugx.org/jawira/mini-getopt/license)](//packagist.org/packages/jawira/mini-getopt)

Usage
-----

This is only a wrapper, therefore the output from `mini-getopt` is going to be 
the same as `getopt()` function.

1. First you have to instantiate `\Jawira\MiniGetopt\MiniGetopt`. 

2. Then you have to configure options you want to use. To do so use the 
following methods:

    - `MiniGetopt::addRequired`.
    - `MiniGetopt::addOptional`.
    - `MiniGetopt::addNoValue`.

3. To retrieve values you have to call one of the following method:

    - `MiniGetopt::getopt` returns the same as `getopt()`. Optionally you  can pass `$optind` parameter.
    - `MiniGetopt::getOption` to get only one value.
    - `MiniGetopt::doc` get documentation.

Basic usage
-----------

PHP code:

```php
// resources/example.php
// Preparing options
$mg = new \Jawira\MiniGetopt\MiniGetopt();
$mg->addRequired('f', 'format');    // value is required
$mg->addOptional('r', 'retry');     // value is optional
$mg->addOptional('q', '');          // only short option
$mg->addNoValue('v', 'verbose');    // no value
$mg->addNoValue('', 'version');     // only long option

// Calling getopt
var_export($mg->getopt());
```

Executing code:

```console
$ php resources/example.php

array (
)
```

```console
$ php resources/example.php -f=xml

array (
   'f' => 'xml',
)
```

```console
$ php resources/example.php --format=xml -r -v

array (
  'format' => 'xml',
  'r' => false,
  'v' => false,
)
```

```console
$ php resources/example.php -f=json -r=yes -v

array (
    'f' => 'json',
    'r' => 'yes',
    'v' => false,
)
```

```console
$ php resources/example.php --retry -vvv

array (
  'retry' => false,
  'v' => 
  array (
    0 => false,
    1 => false,
    2 => false,
  ),
)
```

```console
$ php resources/example.php --version=banana --invalid

array (
  'version' => false,
)
```

`optind` parameter
------------------

```php
// Setup
$mg = new \Jawira\MiniGetopt\MiniGetopt();
$mg->addRequired('f', 'format');
$mg->addNoValue('v', 'verbose');

// Calling getopt function with `optind` parameter
$optind = null;
$options = $mg->getopt($optind);
echo "optind: $optind" . PHP_EOL;
```

```console
$ php resources/example.php --format=pdf -vv
optind: 3
```

Generate doc
------------

```php
$mg = new \Jawira\MiniGetopt\MiniGetopt();
$mg->addRequired('f', 'format', 'Format to export', 'png|gif|svg');
$mg->addOptional('r', 'retry', 'Retry on error', 'count');
$mg->addOptional('q', '', 'Quiet mode', 'yes|no');
$mg->addNoValue('v', 'verbose', 'Display verbose messages');
$mg->addNoValue('', 'version', 'Show version');
echo $mg->doc();
```

```console
$ php resource/example.php
OPTIONS

-f, --format=<png|gif|svg>
Format to export

-r, --retry=[count]
Retry on error

-q=[yes|no]
Quiet mode

-v, --verbose
Display verbose messages

--version
Show version

```


How to install
--------------

```console
$ composer install jawira/mini-getopt
```

Contributing
------------

If you liked this project, ⭐ star it on [GitHub][].

License
-------

This library is licensed under the [MIT license](LICENSE.md).


***

Packages from jawira
--------------------

<dl>

<dt>
    <a href="https://packagist.org/packages/jawira/emoji-catalog">jawira/emoji-catalog
    <img alt="GitHub stars" src="https://badgen.net/github/stars/jawira/emoji-catalog?icon=github"/></a>
</dt>
<dd>Get access to +3000 emojis as class constants.</dd>

<dt>
    <a href="https://packagist.org/packages/jawira/plantuml-encoding"> jawira/plantuml-encoding
    <img alt="GitHub stars" src="https://badgen.net/github/stars/jawira/plantuml-encoding?icon=github"/></a>
</dt>
<dd>PlantUML encoding functions.</dd>

<dt>
    <a href="https://packagist.org/packages/jawira/case-converter">jawira/case-converter 
    <img alt="GitHub stars" src="https://badgen.net/github/stars/jawira/case-converter?icon=github"/></a>
</dt>
<dd>Convert strings between 13 naming conventions: Snake case, Camel case,
  Pascal case, Kebab case, Ada case, Train case, Cobol case, Macro case,
  Upper case, Lower case, Sentence case, Title case and Dot notation.
</dd>

<dt><a href="https://packagist.org/packages/jawira/">more...</a></dt>
</dl>

[Github]: https://github.com/jawira/mini-getopt
