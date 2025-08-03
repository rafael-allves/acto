<?php

namespace Tests\Unit\Utils;

use App\Utils\CompareUtil;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CompareUtilTest extends TestCase
{
    #[Test]
    public function it_compares_equal_nested_arrays()
    {
        $a = [
            'form' => [
                'title' => 'Example',
                'questions' => [
                    ['text' => 'Q1', 'type' => 'open'],
                    ['text' => 'Q2', 'type' => 'multiple_choice'],
                ],
            ],
        ];

        $b = [
            'form' => [
                'title' => 'Example',
                'questions' => [
                    ['text' => 'Q1', 'type' => 'open'],
                    ['text' => 'Q2', 'type' => 'multiple_choice'],
                ],
            ],
        ];

        $this->assertTrue(CompareUtil::deepCompare($a, $b));
    }

    #[Test]
    public function it_detects_different_arrays()
    {
        $a = ['a' => 1, 'b' => 2];
        $b = ['a' => 1, 'b' => 3];

        $this->assertFalse(CompareUtil::deepCompare($a, $b));
    }

    #[Test]
    public function it_handles_different_types()
    {
        $this->assertFalse(CompareUtil::deepCompare(['a'], 'a'));
    }
}
