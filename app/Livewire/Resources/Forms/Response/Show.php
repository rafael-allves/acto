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
    public string $presentationTitle = '';

    public function mount(Form $form, ResponseModel $response): RedirectResponse|null
    {
        $this->form = $form;
        $this->response = $response->load(['user', 'formSnapshot']);

        if (!$this->isAllowed()) {
            session()->flash('error', __('Unauthorized'));
            return redirect()->route('forms.index');
        }

        $createdAt = $response->created_at->format('d/m/Y H:i');

        $this->formSnapshot = $this->response->formSnapshot->data;
        $this->userResponse = $this->response->response;
        $this->presentationTitle = $this->form->owner_id === auth()->id()
            ? __('form.response.presentation_title_owner', ['username' => $response->user->name, 'created_at' => $createdAt])
            : __('form.response.presentation_title_user', ['created_at' => $createdAt]);

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
        return view('livewire.resources.forms.responses.show');
    }
}
