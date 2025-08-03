<?php

namespace Feature\Formulary;

use App\Models\Form\Form;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Form\Question;

class AutoOrdenableTest extends TestCase
{
    use RefreshDatabase;

    #[Test] public function it_sets_order_automatically_on_create()
    {
        $form = Form::factory()->create();
        $questionA = Question::factory()->create(['form_id' => $form->id]);
        $questionB = Question::factory()->create(['form_id' => $form->id]);

        $this->assertEquals(0, $questionA->order);
        $this->assertEquals(1, $questionB->order);
    }
}
