<?php

namespace Peso\Node;

class WhileNode implements Node
{
    public function __construct(
        protected array $nodes = [],
    ) {}

    public function getNodes(): array
    {
        return $this->nodes;
    }

    public function __toString(): string
    {
        return sprintf('\\%s/', implode(array: array_map(fn (Node $node) => (string) $node, $this->nodes)));
    }
}