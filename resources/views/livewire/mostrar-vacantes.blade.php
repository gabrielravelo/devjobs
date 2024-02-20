<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        @forelse ($vacantes as $vacante)
            <div class="p-6 bg-white border-b border-gray-200 md:flex md:justify-between md:items-center">
                <div class="space-y-3">
                    <a href="#" class="text-xl font-bold">
                        {{ $vacante->titulo }}
                    </a>
                    <p class="text-sm  text-gray-600 font-bold">{{ $vacante->empresa }}</p>
                    <p class="text-sm  text-gray-500">Ultimo dia: {{ $vacante->ultimo_dia->format('d/m/Y') }}</p>
                </div>
    
                <div class="flex flex-col md:flex-row gap-3 items-stretch mt-5 md:mt-0">
                    <a href="#" class="text-center bg-slate-800 py-2 px-4 rounded-lg text-white text-sm font-bold uppercase">Candidatos</a>
                    <a href="{{ route('vacantes.edit', $vacante->id) }}" class="text-center bg-blue-800 py-2 px-4 rounded-lg text-white text-sm font-bold uppercase">Editar</a>
                    <button href="#" wire:click="$dispatch('mostrarAlerta', {{ $vacante->id }})" class="text-center bg-red-600 py-2 px-4 rounded-lg text-white text-sm font-bold uppercase">Eliminar</button>
                </div>
            </div>
        @empty
            <p class="p-3 text-center text-sm text-gray-600">No hay vacantes que mostrar</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $vacantes->links() }}
    </div>
</div>

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('mostrarAlerta', vacante => {
            Swal.fire({
                title: 'Eliminar Vacante?',
                text: "Una vacante elimina no se puede recuperar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    // eliminar la vacante
                    Livewire.dispatch('eliminarVacante', {vacante: vacante});
                    Swal.fire(
                        'Se eliminó la vacante!',
                        'Eliminado correctamente.',
                        'success'
                    )
                }
            })
        });
    </script>
@endpush