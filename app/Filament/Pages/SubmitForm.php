<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use App\Models\Form\Form;
use App\Models\Form\Response;
use App\Models\Form\Enums\QuestionType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportRedirects\Redirector;

class SubmitForm extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Form $formModel;
    public array $answers = [];

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static string $view = 'filament.pages.submit-form';
    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string
    {
        return $this->formModel->title;
    }

    public function mount(Form $form): Redirector|null
    {
        $this->formModel = $form->load('questions.alternatives');

        $existingResponse = $this->formModel
            ->responses()
            ->where('user_id', Auth::id())
            ->first();

        if ($existingResponse)
            return $this->redirectForward($existingResponse);
        return null;
    }

    private function redirectForward(Response $response): Redirector
    {
        return redirect()
            ->route('filament.app.pages.view-form-response', ['form' => $this->formModel->id, 'response' => $response->id]);
    }

    protected function getFormSchema(): array
    {
        return $this->formModel->questions->map(function ($question) {
            $required = $question->mandatory;

            return match ($question->type) {
                QuestionType::Open => Forms\Components\Textarea::make("answers.$question->id")
                    ->label(strip_tags($question->text))
                    ->required($required),
                QuestionType::MultipleChoice => Forms\Components\Radio::make("answers.$question->id")
                    ->label(strip_tags($question->text))
                    ->options($question->alternatives->pluck('text', 'id')->toArray())
                    ->required($required),
                default => null,
            };
        })->filter()->toArray();
    }

    /**
     * @throws ValidationException
     */
    public function submit(): Redirector
    {
        $rules = [];
        $messages = [];

        foreach ($this->formModel->questions as $question) {
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


        $snapshotId = $this->formModel->currentSnapshot()->id;

        $response = $this->formModel->responses()->create([
            'snapshot_id' => $snapshotId,
            'response' => $this->answers,
            'user_id' => auth()->id(),
        ]);

        session()
            ->flash('success', __('Successfully saved'));
        return $this->redirectForward($response);
    }
}
