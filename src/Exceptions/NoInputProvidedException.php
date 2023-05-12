<?php

namespace Peso\Exceptions;

use Exception;

class NoInputProvidedException extends Exception
{
    public static function make(): self
    {
        return new self('No input provided.');
    }
}