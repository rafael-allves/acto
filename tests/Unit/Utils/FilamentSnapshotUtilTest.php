<?php

namespace Tests\Unit\Utils;

use App\Utils\FilamentSnapshotUtil;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class FilamentSnapshotUtilTest extends TestCase
{
    #[Test]
    public function it_normalizes_snapshot_data()
    {
        $input = [
            'form' => 'example',
            'questions' => [
                [
                    'record-123' => [
                        0 => ['id' => 1],
                        1 => ['s' => 'arr'],
                    ],
                ],
                ['s' => 'arr'],
            ],
            's' => 'arr',
        ];

        $expected = [
            'form' => 'example',
            'questions' => [
                [
                    0 => ['id' => 1],
                ],
            ],
        ];

        $this->assertEquals($expected, FilamentSnapshotUtil::getData($input));
    }
}
