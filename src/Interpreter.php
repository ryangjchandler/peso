<?php

namespace Peso;

use Peso\Exceptions\NoInputProvidedException;
use Peso\Node\DecrementNode;
use Peso\Node\EchoNode;
use Peso\Node\IncrementNode;
use Peso\Node\MoveLeftNode;
use Peso\Node\MoveRightNode;
use Peso\Node\Node;
use Peso\Node\ReadByteNode;
use Peso\Node\WhileNode;

class Interpreter
{
    protected array $tape = [];

    protected int $tp = 0;

    protected ?string $input = null;

    protected int $ip = 0;

    protected string $output = '';

    public function interpret(Program $program, ?string $input = null)
    {
        $this->tape = array_fill(0, 30_000, 0);
        $this->tp = 0;
        $this->input = $input;
        $this->ip = 0;
        $this->output = '';

        foreach ($program->getNodes() as $node) {
            $this->node($node);
        }
    }

    protected function node(Node $node): void
    {
        if ($node instanceof MoveRightNode) {
            $this->tp++;
        } elseif ($node instanceof MoveLeftNode) {
            $this->tp--;
        } elseif ($node instanceof IncrementNode) {
            if ($this->tape[$this->tp] === 255) {
                $this->tape[$this->tp] = 0;
            } else {
                $this->tape[$this->tp]++;
            }
        } elseif ($node instanceof DecrementNode) {
            if ($this->tape[$this->tp] === 0) {
                $this->tape[$this->tp] = 255;
            } else {
                $this->tape[$this->tp]--;
            }
        } elseif ($node instanceof ReadByteNode) {
            if ($this->input === null) {
                throw NoInputProvidedException::make();
            }

            $this->tape[$this->tp] = ord($this->input[$this->ip]);
            $this->ip++;
        } elseif ($node instanceof WhileNode) {
            while (true) {
                foreach ($node->getNodes() as $child) {
                    $this->node($child);
                }

                if ($this->tape[$this->tp] === 0) {
                    break;
                }
            }
        } elseif ($node instanceof EchoNode) {
            $this->output .= chr($this->tape[$this->tp]);
        }
    }

    public function getOutput(): string
    {
        return $this->output;
    }
}