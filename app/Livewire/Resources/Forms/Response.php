<?php

namespace App\Livewire\Resources\Forms;

use App\Models\Form\Enums\QuestionType;
use App\Models\Form\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Response extends Component
{
    public Form $form;
    public array $answers = [];

    public function mount(Form $form): void
    {
        $this->form = $form->load([
            'questions.alternatives'
        ]);
    }

    public function submit(): RedirectResponse
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


        $snapshotId = $this->form->currentSnapshot()->id;

        $this->form->responses()->create([
            'snapshot_id' => $snapshotId,
            'response' => $this->answers,
            'user_id' => auth()->id(),
        ]);

        return redirect(route(''));
    }

    public function render(): View
    {
        return view('livewire.forms.answer-form');
    }
}
