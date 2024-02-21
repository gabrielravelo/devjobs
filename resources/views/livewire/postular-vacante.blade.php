<div class="bg-gray-100 p-5 mt-10 flex flex-col justify-center items-center">
    <h3 class="text-center text-2xl font-bold my-4">Postularme a esta vacante</h3>

    @if (session()->has('mensaje'))
        <div class="uppercase border border-green-600 bg-green-100 text-green-600 font-bold p-2 my-3 text-sm">
            {{ session('mensaje') }}
        </div>
    @else
        <form class="w-96 mt-5" wire:submit.prevent='postularme'>
            <div class="mb-4">
                <x-input-label for="cv" :value="__('CV u Hoja de Vida (PDF)')" />
                <x-text-input id="imagen" class="block mt-1 w-full" type="file" wire:model="imagen" accept=".pdf" />
                <x-input-error :messages="$errors->get('cv')" class="mt-2" />
            </div>

            <x-primary-button class="my-5">a
                Postularme
            </x-primary-button>
        </form>
    @endif
</div>
