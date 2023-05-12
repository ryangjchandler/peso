<?php

use Peso\Exceptions\UnexpectedCharacterException;
use Peso\Lexer;
use Peso\Token;

it('produces the correct tokens', function () {
    $lexer = new Lexer;

    expect($lexer->tokenise('=> <= + - echo $ \ /'))
        ->toBe([
            Token::RightDoubleArrow,
            Token::LeftDoubleArrow,
            Token::Plus,
            Token::Minus,
            Token::Echo,
            Token::Dollar,
            Token::Backslash,
            Token::Slash
        ]);
});

it('throws an exception when encountering an unexpected character', function () {
    $lexer = new Lexer;

    expect(fn () => $lexer->tokenise('foo'))
        ->toThrow(UnexpectedCharacterException::class, 'Unexpected character f');
});