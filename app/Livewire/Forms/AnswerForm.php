<?php

namespace App\Livewire\Forms;

use App\Models\Form\Enums\QuestionType;
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
        $messages = [];

        foreach ($this->form->questions as $question) {
            $key = 'answers.' . $question->id;

            $requiredRule = $question->mandatory ? ['required'] : ['nullable'];

            $typeRule = match ($question->type) {
                QuestionType::Open => 'string',
                QuestionType::MultipleChoice => 'in:' . implode(',', $question->alternatives->pluck('id')->toArray()),
            };

            $rules[$key] = array_merge($requiredRule, [$typeRule]);

            if ($question->mandatory)
                $messages["$key.required"] = __('Required Field');

            if ($question->type === QuestionType::MultipleChoice)
                $messages["$key.in"] = __('Invalid alternative');
        }

        Validator::make(
            ['answers' => $this->answers],
            $rules,
            $messages
        )
            ->validate();

        dd($this->answers);

        $this->form->responses()->create([

        ]);

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
