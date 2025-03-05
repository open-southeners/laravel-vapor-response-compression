<?php

namespace OpenSoutheners\LaravelResponseCompression\Tests;

use OpenSoutheners\LaravelResponseCompression\CompressionEncoding;
use PHPUnit\Framework\TestCase;

class CompressionEncodingTest extends TestCase
{
    public function testCompressionEncodingListSupportedReturnsArray()
    {
        $supportedList = CompressionEncoding::listSupported();
        
        $this->assertIsArray($supportedList);
        $this->assertArrayHasKey(CompressionEncoding::Deflate->value, $supportedList);
        $this->assertEmpty(array_diff(
            array_map(fn ($case) => $case->value, CompressionEncoding::cases()),
            array_keys($supportedList),
        ));
    }
}
