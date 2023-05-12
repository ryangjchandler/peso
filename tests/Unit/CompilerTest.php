<?php

use Peso\Compiler;
use Peso\Lexer;
use Peso\Parser;

it('can compile a program that adds two numbers', function () {
    $tokens = (new Lexer)->tokenise('$ ------------------------------------------------ => $ \ <= + => - / <= echo');
    $program = (new Parser)->parse($tokens);

    $compiler = new Compiler;
    $callback = $compiler->compile($program);

    expect($callback('12'))
        ->toBe('3');
});