<?php

namespace App\Livewire\Resources\Forms;

use App\Models\Form\Enums\QuestionType;
use App\Models\Form\Form;
use App\Models\Form\Response;
use Illuminate\Contracts\View\View;
use Livewire\Features\SupportRedirects\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Show extends Component
{
    public Form $form;
    public array $answers = [];

    public function mount(Form $form): Redirector|null
    {
        $this->form = $form->load([
            'questions.alternatives'
        ]);
        $loggedUserId = auth()->id();
        $response = $this->form
            ->responses()
            ->firstWhere('user_id', $loggedUserId);
        if ($response) return $this->redirectForward($response);
        return null;
    }

    private function redirectForward(Response $response): Redirector
    {
        return redirect()
            ->route(
                'forms.responses.show',
                ['form' => $this->form, 'response' => $response]
            );
    }

    /**
     * @throws ValidationException
     */
    public function submit(): Redirector
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

        $response = $this->form->responses()->create([
            'snapshot_id' => $snapshotId,
            'response' => $this->answers,
            'user_id' => auth()->id(),
        ]);

        session()
            ->flash('success', __('Successfully saved'));
        return $this->redirectForward($response);
    }

    public function render(): View
    {
        return view('livewire.forms.answer-form');
    }
}
