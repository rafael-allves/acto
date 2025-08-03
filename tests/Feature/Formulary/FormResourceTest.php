<?php

namespace Feature\Formulary;

use App\Filament\Resources\FormResource\Pages\CreateForm;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormResourceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_allows_creating_a_form()
    {
        $this->actingAsUser();

        Livewire::test(CreateForm::class)
            ->fillForm([
                'title' => 'Meu Formulário',
                'description' => 'Descrição aqui',
                'is_active' => true,
            ])
            ->set('data.questions', [
                [
                    'text' => 'Qual sua cor favorita?',
                    'type' => 'open',
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('forms', [
            'title' => 'Meu Formulário',
        ]);
    }


    protected function actingAsUser()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
    }
}
