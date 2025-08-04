<?php

namespace App\Livewire\Resources\Forms\Response;

use App\Models\Form\Form;
use App\Models\Form\Response as ResponseModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
{
    private Form $form;
    private ResponseModel $response;
    public array $formSnapshot = [];
    public array $userResponse = [];

    public function mount(Form $form, ResponseModel $response): RedirectResponse|null
    {
        $this->form = $form;
        $this->response = $response->load(['user', 'formSnapshot']);

        if (!$this->isAllowed()) {
            session()->flash('error', __('Unauthorized'));
            return redirect()->route('forms.index');
        }

        $this->formSnapshot = $this->response->formSnapshot->data;
        $this->userResponse = $this->response->response;

        return null;
    }

    private function isAllowed(): bool
    {
        $loggedUserId = auth()->id();

        return $this->form->owner_id === $loggedUserId ||
            $this->response->user_id === $loggedUserId;
    }

    public function render(): View
    {
        return view('livewire.forms.answers.show');
    }
}
