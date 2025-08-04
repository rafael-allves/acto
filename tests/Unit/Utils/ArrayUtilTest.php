<?php

namespace Tests\Unit\Utils;

use App\Utils\ArrayUtil;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ArrayUtilTest extends TestCase
{
    #[Test] public function it_removes_s_keys_recursively()
    {
        $input = [
            'a' => 1,
            'b' => ['s' => 'arr'],
            'c' => [
                'd' => ['s' => 'arr'],
                'e' => 'value'
            ]
        ];

        $expected = [
            'a' => 1,
            'c' => ['e' => 'value']
        ];

        $this->assertEquals($expected, ArrayUtil::removeArrayKey($input, 's'));
    }
}
