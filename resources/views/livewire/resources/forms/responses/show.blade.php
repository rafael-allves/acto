@php use App\Models\Form\Enums\QuestionType; @endphp

<x-slot name="header">
    <h1 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
        {{ $presentationTitle }}
    </h1>

    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $formSnapshot['title'] }}
    </h2>
    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-6">
        {!! $formSnapshot['description'] !!}
    </h3>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach($formSnapshot['questions'] as $index => $question)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div>
                        <h3 class="flex items-start gap-3 p-3 text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ $index + 1 }}.

                            @if ($question['mandatory'])
                                <span class="text-red-600">*</span>
                            @endif

                            {!! $question['text'] !!}
                        </h3>
                    </div>

                    @if($question['type'] === QuestionType::MultipleChoice->value)
                        <div>
                            <div class="space-y-3">
                                @foreach($question['alternatives'] as $alternative)
                                    <label
                                        class="flex items-start gap-3 p-3 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                        <input
                                            type="radio"
                                            value="{{ $alternative['id'] }}"
                                            class="mt-1.5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                            @checked($userResponse[$question['id']] == $alternative['id'])
                                            disabled
                                        >
                                        <span class="text-black dark:text-white leading-snug">
                                            {!! $alternative['text'] !!}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @elseif($question['type'] === QuestionType::Open->value)
                        <x-textarea
                            class="w-full"
                            rows="4"
                            disabled
                            value="{{$userResponse[$question['id']]}}"
                        />
                    @endif
                </div>
            @endforeach
        </form>
    </div>
</div>
