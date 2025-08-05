@php use App\Models\Form\Enums\QuestionType; @endphp
<x-filament::page>
    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-6">
        {!! $this->formModel->description !!}
    </h3>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form wire:submit.prevent="submit" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                @foreach($this->formModel->questions as $index => $question)
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div>
                            <h3 class="flex items-start gap-3 p-3 text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ $index + 1 }}.

                                @if ($question->mandatory)
                                    <span class="text-red-600" style="color:red;">*</span>
                                @endif

                                {!! $question->text !!}
                            </h3>
                        </div>

                        @if($question->type === QuestionType::MultipleChoice)
                            <div>
                                <div class="space-y-3">
                                    @foreach($question->alternatives as $alternative)
                                        <label
                                            class="flex items-start gap-3 p-3 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                            <input
                                                type="radio"
                                                wire:model.defer="answers.{{ $question->id }}"
                                                value="{{ $alternative->id }}"
                                                class="mt-1.5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                            >
                                            <span class="text-black dark:text-white leading-snug">
                                                {!! $alternative->text !!}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @elseif($question->type === QuestionType::Open)
                            <x-textarea
                                wire:model.defer="answers.{{ $question->id }}"
                                class="w-full"
                                rows="4"
                            />
                        @endif

                        @error("answers.$question->id")
                        <p class="text-sm text-red-500" style="color:red;">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <div class="flex justify-end">
                    <x-filament::button type="submit" class="mt-6">
                        Enviar respostas
                    </x-filament::button>
                </div>
            </form>
        </div>
    </div>
</x-filament::page>
