<?php

namespace Peso;

use Peso\Exceptions\UnexpectedCharacterException;

class Lexer
{
    /** @return array<Token> */
    public function tokenise(string $input): array
    {
        $chars = str_split($input);
        $tokens = [];

        for ($i = 0; $i < count($chars); $i++) {
            $char = $chars[$i];

            if ($char === '$') {
                $tokens[] = Token::Dollar;
            } elseif ($char === '\\') {
                $tokens[] = Token::Backslash;
            } elseif ($char === '/') {
                $tokens[] = Token::Slash;
            } elseif ($char === '+') {
                $tokens[] = Token::Plus;
            } elseif ($char === '-') {
                $tokens[] = Token::Minus;
            } elseif ($char === '=') {
                if ($chars[++$i] === '>') {
                    $tokens[] = Token::RightDoubleArrow;
                } else {
                    throw UnexpectedCharacterException::make($char, expected: '>');
                }
            } elseif ($char === '<') {
                if ($chars[++$i] === '=') {
                    $tokens[] = Token::LeftDoubleArrow;
                } else {
                    throw UnexpectedCharacterException::make($char, expected: '=');
                }
            } elseif (array_slice($chars, $i, 4) === ['e', 'c', 'h', 'o']) {
                $i += 3;
                $tokens[] = Token::Echo;
            } elseif (ctype_space($char)) {
                continue;
            } else {
                throw UnexpectedCharacterException::make($char);
            }
        }

        return $tokens;
    }
}