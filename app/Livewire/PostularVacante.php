<?php

namespace App\Livewire;

use App\Models\Vacante;
use App\Notifications\NuevoCandidato;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class PostularVacante extends Component
{
    use WithFileUploads;

    public $imagen;
    public $vacante;

    protected $rules = [
        'imagen' => 'required|mimes:pdf'
    ];

    public function mount(Vacante $vacante)
    {
        $this->vacante = $vacante;
    }

    public function postularme()
    {
        $data = $this->validate();

        // almacenar el cv
        $cv = $this->imagen->store('public/cv');
        $data['cv'] = str_replace('public/cv/', '', $cv);
        // almacenar CV en el disco duro

        // crear el candidato
        $this->vacante->candidatos()->create([
            'user_id' => auth()->user()->id,
            'cv' => $data['cv']
        ]);

        // crear notificacion y enviar email
        $this->vacante->reclutador->notify(new NuevoCandidato($this->vacante->id, $this->vacante->titulo, auth()->user()->id));

        // mostrar al usuario un mensaje de ok
        session()->flash('mensaje', 'Se envió correctamente tu información, mucha suerte!');

        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.postular-vacante');
    }
}
