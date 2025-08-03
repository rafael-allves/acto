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

    #[Test] public function it_promotes_record_keys()
    {
        $input = [
            'questions' => [
                ['record-1' => ['id' => 1]],
                ['record-2' => ['id' => 2]],
                ['record-3' => ['id' => 3]],
            ],
            'form' => 'example'
        ];

        $expected = [
            'questions' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
            ],
            'form' => 'example'
        ];

        $this->assertEquals($expected, ArrayUtil::promoteRecordKeys($input));
    }
}
