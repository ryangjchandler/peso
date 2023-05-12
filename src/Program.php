<?php

namespace Peso;

class Program
{
    public function __construct(
        protected array $nodes = [],
    ) {}

    public function getNodes(): array
    {
        return $this->nodes;
    }
}