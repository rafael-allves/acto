<?php

namespace Feature\Formulary;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Form\Form;

class AutoOrdenableParentTest extends TestCase
{
    use RefreshDatabase;

    #[Test] public function it_deletes_removed_questions_and_orders_remaining()
    {
        $form = Form::factory()->create();

        $q1 = $form->questions()->create(['text' => 'Q1', 'type' => 'multiple_choice', 'mandatory' => true]);
        $q2 = $form->questions()->create(['text' => 'Q2', 'type' => 'multiple_choice', 'mandatory' => true]);
        $q3 = $form->questions()->create(['text' => 'Q3', 'type' => 'multiple_choice', 'mandatory' => true]);

        $form->update([
            'questions' => [
                ['id' => $q1->id, 'text' => 'Q1 updated', 'type' => 'multiple_choice', 'mandatory' => true],
                ['id' => $q3->id, 'text' => 'Q3 updated', 'type' => 'multiple_choice', 'mandatory' => true],
            ],
        ]);

        $this->assertSoftDeleted('form_questions', ['id' => $q2->id]);
        $this->assertDatabaseHas('form_questions', ['id' => $q1->id, 'order' => 0]);
        $this->assertDatabaseHas('form_questions', ['id' => $q3->id, 'order' => 1]);
    }
}
