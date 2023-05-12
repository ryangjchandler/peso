<?php

use Peso\Lexer;
use Peso\Node\DecrementNode;
use Peso\Node\EchoNode;
use Peso\Node\IncrementNode;
use Peso\Node\MoveLeftNode;
use Peso\Node\MoveRightNode;
use Peso\Node\ReadByteNode;
use Peso\Node\WhileNode;
use Peso\Parser;
use Peso\Program;
use Pest\Expectation;

it('can parse all nodes', function () {
    $tokens = (new Lexer)->tokenise('=> <= + - echo $ \echo/');
    $parser = new Parser;

    expect($parser->parse($tokens))
        ->toBeInstanceOf(Program::class)
        ->getNodes()
        ->sequence(
            fn (Expectation $expect) => $expect->toBeInstanceOf(MoveRightNode::class),
            fn (Expectation $expect) => $expect->toBeInstanceOf(MoveLeftNode::class),
            fn (Expectation $expect) => $expect->toBeInstanceOf(IncrementNode::class),
            fn (Expectation $expect) => $expect->toBeInstanceOf(DecrementNode::class),
            fn (Expectation $expect) => $expect->toBeInstanceOf(EchoNode::class),
            fn (Expectation $expect) => $expect->toBeInstanceOf(ReadByteNode::class),
            fn (Expectation $expect) => $expect->toBeInstanceOf(WhileNode::class)
                ->getNodes()
                ->sequence(
                    fn (Expectation $expect) => $expect->toBeInstanceOf(EchoNode::class)
                ),
        );
});