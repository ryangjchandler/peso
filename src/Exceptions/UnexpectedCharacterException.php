<?php

namespace Peso\Exceptions;

use Exception;

class UnexpectedCharacterException extends Exception
{
    public static function make(string $character, ?string $expected = null): self
    {
        return new self(
            $expected !== null ? "Unexpected character {$character}, expected {$expected}" : "Unexpected character {$character}"
        );
    }
}