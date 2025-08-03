<?php

namespace App\Livewire\Forms;

use App\Models\Form\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AnswerForm extends Component
{
    public Form $form;
    public array $answers = [];

    public function mount(Form $form): void
    {
        $this->form = $form->load([
            'questions.alternatives'
        ]);
    }

    public function submit(): void
    {
        $rules = [];

        foreach ($this->form->questions as $question) {
            $key = 'answers.' . $question->id;
            $rules[$key] = $question->mandatory ? ['required'] : ['nullable'];
        }

        Validator::make($this->answers, $rules)
            ->validate();

        logger()
            ->info(
                'Respostas recebidas', $this->answers
            );

        session()->flash('message', 'Formulário respondido com sucesso!');
        $this->reset('answers');
    }

    public function render(): View
    {
        return view('livewire.forms.answer-form');
    }
}
