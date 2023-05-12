<?php

namespace Peso\Node;

class ReadByteNode implements Node
{
    public function __toString(): string
    {
        return '$';
    }
}