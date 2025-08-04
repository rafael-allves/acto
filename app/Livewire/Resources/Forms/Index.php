<?php

namespace App\Livewire\Resources\Forms;

use App\Models\Form\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $forms = Form::query()
            ->where('is_active', true)
            ->when($this->search, fn (Builder $query) =>
            $query->where('title', 'like', '%' . $this->search . '%')
            )
            ->latest()
            ->paginate(20);

        return view('welcome', [
            'forms' => $forms,
        ]);
    }
}

