<?php

namespace Tests\Unit\Utils;

use App\Utils\FilamentSnapshotUtil;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class FilamentSnapshotUtilTest extends TestCase
{
    #[Test]
    public function it_normalizes_Snapshot_data()
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

    #[Test]
    public function it_remove_timestamps(){
        $input = [
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00',
        ];

        $this->assertEquals([], FilamentSnapshotUtil::getData($input));
    }

    #[Test]
    public function it_keeps_time_stamps(){
        $input = [
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00',
        ];
        $this->assertEquals([
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00',
        ], FilamentSnapshotUtil::getData($input, true));
    }
}
