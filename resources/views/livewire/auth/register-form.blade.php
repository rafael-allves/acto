<form wire:submit.prevent="register" class="space-y-4 w-full max-w-sm bg-white p-6 rounded shadow">
    <div>
        <label for="name" class="block text-sm font-medium">Nome</label>
        <input id="name" type="text" wire:model.defer="name" class="w-full border rounded px-3 py-2">
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium">E-mail</label>
        <input id="email" type="email" wire:model.defer="email" class="w-full border rounded px-3 py-2">
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium">Senha</label>
        <input id="password" type="password" wire:model.defer="password" class="w-full border rounded px-3 py-2">
        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium">Confirmar Senha</label>
        <input id="password_confirmation" type="password" wire:model.defer="password_confirmation"
               class="w-full border rounded px-3 py-2">
    </div>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
        Registrar
    </button>
</form>
