<?php

namespace OpenSoutheners\LaravelVaporResponseCompression;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class EncoderAsFunction
{
    public function __construct(public string $name)
    {
        // 
    }
}
