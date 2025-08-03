<x-layouts.guest>
    <form method="POST" action="{{ route('register') }}" class="space-y-4 w-full max-w-sm bg-white p-6 rounded shadow">
        @csrf
        {{ $form }}
        <x-filament::button type="submit" class="w-full">Registrar</x-filament::button>
    </form>
</x-layouts.guest>
