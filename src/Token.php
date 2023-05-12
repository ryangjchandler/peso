<?php

namespace Peso;

enum Token
{
    case RightDoubleArrow;
    case LeftDoubleArrow;
    case Plus;
    case Minus;
    case Echo;
    case Dollar;
    case Backslash;
    case Slash;

    public function toString(): string
    {
        return match ($this) {
            self::RightDoubleArrow => '=>',
            self::LeftDoubleArrow => '<=',
            self::Plus => '+',
            self::Minus => '-',
            self::Echo => 'echo',
            self::Dollar => '$',
            self::Backslash => '\\',
            self::Slash => '/'
        };
    }
}