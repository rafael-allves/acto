<?php

namespace Database\Factories\Form;

use App\Models\Form\Form;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Form\Form>
 */

class FormFactory extends Factory
{
    protected $model = Form::class;

    public function definition(): array
    {
        return [
            'owner_id'     => User::factory(),
            'title'       => $this->faker->unique()->sentence(3),
            'description' => $this->faker->paragraph(),
            'is_active'   => true,
        ];
    }
}
