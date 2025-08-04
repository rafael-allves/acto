@php use Illuminate\Support\Str; @endphp
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('form.plural') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="flex justify-between items-center">
            <input
                type="search"
                wire:model.live="search"
                placeholder="{{ __('form.search') }}"
                class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
            />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($forms as $form)
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 flex flex-col justify-between"
                     wire:key="form-{{ $form->id }}">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                            {{ $form->title }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            {{ Str::limit(strip_tags($form->description)) }}
                        </p>
                    </div>

                    <div class="mt-4 text-right">
                        <a
                            href="{{ route('forms.show', $form) }}"
                            class="text-sm font-medium text-indigo-600 hover:underline dark:text-indigo-400"
                            wire:navigate
                        >
                            {{ __('See') }} →
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 dark:text-gray-300">
                    {{ __('Nenhum formulário encontrado.') }}
                </div>
            @endforelse
        </div>

        <div>
            {{ $forms->links() }}
        </div>
    </div>
</div>
