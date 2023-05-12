<?php

namespace Peso\Node;

class MoveRightNode implements Node
{
    public function __toString(): string
    {
        return '=>';
    }
}