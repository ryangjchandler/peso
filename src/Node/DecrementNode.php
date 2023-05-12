<?php

namespace Peso\Node;

class DecrementNode implements Node
{
    public function __toString(): string
    {
        return '-';
    }
}