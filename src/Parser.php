<?php

namespace Peso;

use Peso\Exceptions\UnexpectedTokenException;
use Peso\Node\DecrementNode;
use Peso\Node\EchoNode;
use Peso\Node\IncrementNode;
use Peso\Node\MoveLeftNode;
use Peso\Node\MoveRightNode;
use Peso\Node\Node;
use Peso\Node\ReadByteNode;
use Peso\Node\WhileNode;

class Parser
{
    protected ?Token $current = null;
    
    protected ?Token $next = null;

    protected int $position = 0;

    protected array $tokens;

    public function parse(array $tokens): Program
    {
        if (count($tokens) === 0) {
            return new Program();
        }

        $this->tokens = $tokens;
        $this->current = $tokens[$this->position];
        $this->next = $tokens[$this->position + 1] ?? null;

        $nodes = [];

        while ($this->position < count($tokens)) {
            $nodes[] = $this->node();
        }

        return new Program($nodes);
    }

    protected function node(): Node
    {
        if ($this->current === Token::Plus) {
            $this->next();
            return new IncrementNode;
        } elseif ($this->current === Token::Minus) {
            $this->next();
            return new DecrementNode;
        } elseif ($this->current === Token::RightDoubleArrow) {
            $this->next();
            return new MoveRightNode;
        } elseif ($this->current === Token::LeftDoubleArrow) {
            $this->next();
            return new MoveLeftNode;
        } elseif ($this->current === Token::Dollar) {
            $this->next();
            return new ReadByteNode;
        } elseif ($this->current === Token::Echo) {
            $this->next();
            return new EchoNode;
        } elseif ($this->current === Token::Backslash) {
            $this->next();

            $nodes = [];

            while ($this->current !== null && $this->current !== Token::Slash) {
                $nodes[] = $this->node();
            }

            $this->expect(Token::Slash);

            return new WhileNode($nodes);
        } else {
            throw UnexpectedTokenException::make($this->current);
        }
    }

    protected function expect(Token $token): void
    {
        if ($this->current !== $token) {
            throw UnexpectedTokenException::make($this->current);
        }

        $this->next();
    }

    protected function next(): void
    {
        $this->position++;

        $this->current = $this->next;
        $this->next = $this->tokens[$this->position + 1] ?? null;
    }
}