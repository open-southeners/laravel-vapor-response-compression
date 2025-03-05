<?php

namespace OpenSoutheners\LaravelResponseCompression;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class EncoderAsFunction
{
    public function __construct(public string $name)
    {
        // 
    }
}
