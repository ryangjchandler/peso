<?php

namespace Peso;

use Closure;
use Peso\Node\DecrementNode;
use Peso\Node\EchoNode;
use Peso\Node\IncrementNode;
use Peso\Node\MoveLeftNode;
use Peso\Node\MoveRightNode;
use Peso\Node\Node;
use Peso\Node\ReadByteNode;
use Peso\Node\WhileNode;

class Compiler
{
    public function compile(Program $program): Closure
    {
        $php = sprintf(<<<'PHP'
        <?php

        return function (?string $input = null): string {
            $tape = array_fill(0, 30_000, 0);
            $tp = 0;
            $ip = 0;
            $output = '';

            %s

            return $output;
        };
        PHP, $this->generate($program));

        $temp = tempnam(sys_get_temp_dir(), 'peso-');

        file_put_contents($temp, $php);

        return require $temp;
    }

    public function generate(Program $program): string
    {
        $code = '';

        foreach ($program->getNodes() as $node) {
            $code .= $this->node($node);
        }

        return $code;
    }

    protected function node(Node $node): string
    {
        if ($node instanceof MoveRightNode) {
            return '$tp++;';
        }
        
        if ($node instanceof MoveLeftNode) {
            return '$tp--;';
        }

        if ($node instanceof IncrementNode) {
            return <<<'PHP'
            if ($tape[$tp] === 255) {
                $tape[$tp] = 0;
            } else {
                $tape[$tp]++;
            }
            PHP;
        }
        
        if ($node instanceof DecrementNode) {
            return <<<'PHP'
            if ($tape[$tp] === 0) {
                $tape[$tp] = 255;
            } else {
                $tape[$tp]--;
            }
            PHP;
        } 
        
        if ($node instanceof ReadByteNode) {
            return <<<'PHP'
            if ($input === null) {
                throw \Peso\Exceptions\NoInputProvidedException::make();
            }

            $tape[$tp] = ord($input[$ip]);
            $ip++;
            PHP;
        }

        if ($node instanceof WhileNode) {
            $code = 'while (true):';

            foreach ($node->getNodes() as $child) {
                $code .= $this->node($child);
            }

            return $code . <<<'PHP'
                if ($tape[$tp] === 0) {
                    break;
                }
            endwhile;
            PHP;
        }

        if ($node instanceof EchoNode) {
            return <<<'PHP'
            $output .= chr($tape[$tp]);
            PHP;
        }
    }
}