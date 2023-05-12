<?php

namespace Peso\Exceptions;

use Exception;
use Peso\Token;

class UnexpectedTokenException extends Exception
{
    public static function make(Token $token): self
    {
        return new self("Unexpected token {$token->toString()} ({$token->name})");
    }
}