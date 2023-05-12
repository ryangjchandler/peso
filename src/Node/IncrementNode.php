<?php

namespace Peso\Node;

class IncrementNode implements Node
{
    public function __toString(): string
    {
        return '+';
    }
}