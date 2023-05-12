<?php

namespace Peso\Node;

class MoveLeftNode implements Node
{
    public function __toString(): string
    {
        return '<=';
    }
}