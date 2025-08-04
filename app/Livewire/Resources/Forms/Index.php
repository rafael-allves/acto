<?php

namespace App\Livewire\Resources\Forms;

use App\Models\Form\Form;
use App\Utils\SqlUtil;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function render(): View
    {
        $forms = Form::query()
            ->where('is_active', true)
            ->when($this->search, fn (Builder $query) =>
            $query->where('title', 'like', '%' . $this->search . '%')
            )
            ->latest()
            ->paginate(SqlUtil::PAGINATION);

        return view('livewire.resources.forms.index', [
            'forms' => $forms,
        ]);
    }
}
