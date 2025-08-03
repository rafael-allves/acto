<?php

namespace Database\Factories\Form;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Form\Form;
use App\Models\Form\Question;
use App\Models\Form\Enums\QuestionType;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'form_id'   => Form::factory(),
            'text'      => $this->faker->sentence(),
            'type'      => $this->faker->randomElement([QuestionType::Open, QuestionType::MultipleChoice]),
            'order'     => $this->faker->unique()->numberBetween(0, 100),
            'mandatory' => true,
        ];
    }
}
