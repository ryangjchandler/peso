<?php

use Peso\Interpreter;
use Peso\Lexer;
use Peso\Parser;

it('can add two numbers', function () {
    $tokens = (new Lexer)->tokenise('$ ------------------------------------------------ => $ \ <= + => - / <= echo');
    $program = (new Parser)->parse($tokens);
    
    $interpreter = new Interpreter;
    $interpreter->interpret($program, '12');

    expect($interpreter->getOutput())
        ->toBe('3');
});

it('can print hello world', function () {
    $tokens = (new Lexer)->tokenise('++++++++++\=>+=>+++=>+++++++=>++++++++++<=<=<=<=-/=>=>=>++echo=>+echo+++++++echoecho+++echo<=<=++echo=>+++++++++++++++echo=>echo+++echo------echo--------echo<=<=+echo');
    $program = (new Parser)->parse($tokens);
    
    $interpreter = new Interpreter;
    $interpreter->interpret($program);

    expect($interpreter->getOutput())
        ->toBe('Hello World!');
});