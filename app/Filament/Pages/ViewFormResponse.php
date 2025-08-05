<?php

namespace App\Filament\Pages;

use App\Models\Form\Form;
use App\Models\Form\Response;
use Filament\Pages\Page;
use Livewire\Features\SupportRedirects\Redirector;

class ViewFormResponse extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.view-form-response';
    protected static bool $shouldRegisterNavigation = false;

    private Form $form;
    private Response $response;
    public array $formSnapshot = [];
    public array $userResponse = [];
    public string $presentationTitle = '';

    public function getTitle(): string
    {
        return $this->formSnapshot['title'];
    }

    public function mount(Form $form, Response $response): Redirector|null
    {
        $this->form = $form;
        $this->response = $response->load(['user', 'formSnapshot']);

        if (!$this->isAllowed()) {
            session()->flash('error', __('Unauthorized'));
            return redirect()->route('welcome');
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
}
