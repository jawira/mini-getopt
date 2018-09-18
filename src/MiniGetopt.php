<?php

namespace Jawira\MiniGetopt;


class MiniGetopt
{
    const NO_VALUE = '';
    const REQUIRED = ':';
    const OPTIONAL = '::';

    protected $options = [];

    public function setRequired(string $short, string $long, string $description = '', string $placeholder = 'value')
    {
        $this->setOption(self::REQUIRED, $short, $long, $description, $placeholder);
        return $this;
    }

    public function setOptional(string $short, string $long, string $description = '', string $placeholder = 'value')
    {
        $this->setOption(self::OPTIONAL, $short, $long, $description, $placeholder);
        return $this;
    }

    public function setNoValue(string $short, string $long, string $description = '')
    {
        $this->setOption(self::NO_VALUE, $short, $long, $description, '');
        return $this;
    }

    protected function setOption(string $type, string $short, string $long, string $description, string $placeholder)
    {
        $this->validateShortAndLong($short, $long);

        $this->options[] = compact('type', 'short', 'long', 'description', 'placeholder');
        return $this;
    }

    protected function validShort(string $short)
    {
        return mb_strlen($short) <= 1;
    }

    protected function validLong(string $long)
    {
        return mb_strlen($long) !== 1;
    }

    protected function noEmptyString(string $string)
    {
        return mb_strlen($string) > 0;
    }

    protected function emptyString(string $string)
    {
        return !$this->noEmptyString($string);
    }

    public function getopt()
    {
        $shortOptions = '';
        $longOptions  = [];

        foreach ($this->options as $option) {
            /**
             * @var string $type
             * @var string $short
             * @var string $long
             * @var string $description
             * @var string $placeholder
             */
            extract($option, EXTR_OVERWRITE);
            if ($this->noEmptyString($short)) {
                $shortOptions .= $short . $type;
            }
            if ($this->noEmptyString($long)) {
                $longOptions[] = $long . $type;
            }
        }

        return \getopt($shortOptions, $longOptions);
    }

    public function doc()
    {
        $doc = 'OPTIONS' . PHP_EOL;

        foreach ($this->options as $option) {
            /**
             * @var string $type
             * @var string $short
             * @var string $long
             * @var string $description
             * @var string $placeholder
             */
            extract($option, EXTR_OVERWRITE);
            $names = [];
            if ($this->noEmptyString($short)) {
                $names[] = "-$short";
            }
            if ($this->noEmptyString($long)) {
                $names[] = "--$long";
            }
            $summary = implode(', ', $names);
            if ($this->noEmptyString($placeholder)) {
                switch ($type) {
                    case self::REQUIRED:
                        $summary .= " <$placeholder>";
                        break;
                    case self::OPTIONAL:
                        $summary .= " [$placeholder]";
                        break;
                }
            }

            $doc .= $summary . PHP_EOL;

            if ($this->noEmptyString($description)) {
                $doc .= wordwrap($description, 72, PHP_EOL) . PHP_EOL;
            }

            $doc .= PHP_EOL;
        }

        return $doc;
    }

    public function getOption(string $short, string $long, $default = null): ?string
    {
        $this->validateShortAndLong($short, $long);
        $getopt = $this->getopt();
        if (array_key_exists($short, $getopt)) {
            return $getopt[$short];
        }
        if (array_key_exists($long, $getopt)) {
            return $getopt[$long];
        }

        return $default;
    }

    public function isOption(string $option): bool
    {
        return array_key_exists($option, $this->getopt());
    }

    /**
     * @param string $short
     * @param string $long
     *
     * @return \Jawira\MiniGetopt\MiniGetopt
     * @throws \Exception
     */
    protected function validateShortAndLong(string $short, string $long): self
    {
        if (!$this->validShort($short)) {
            throw new \Exception("Short option '$short' should be one character long");
        }
        if (!$this->validLong($long)) {
            throw new \Exception("Long option '$long' should be at least two characters long");
        }
        if ($this->emptyString($short) && $this->emptyString($long)) {
            throw new \Exception("You should define at least short option or long option");
        }
        return $this;
    }
}