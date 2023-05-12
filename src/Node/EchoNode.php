<?php

namespace Peso\Node;

class EchoNode implements Node
{
    public function __toString(): string
    {
        return 'echo';
    }
}