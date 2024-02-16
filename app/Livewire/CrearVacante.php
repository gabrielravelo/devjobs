<?php

namespace App\Livewire;

use App\Models\Salario;
use Livewire\Component;
use App\Models\Categoria;
use App\Models\Vacante;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CrearVacante extends Component
{
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;

    use WithFileUploads;

    protected $rules = [
        'titulo' => 'required|string',
        'salario' => 'required',
        'categoria' => 'required',
        'empresa' => 'required',
        'ultimo_dia' => 'required',
        'descripcion' => 'required',
        'imagen' => 'required|image|max:1024',
    ];

    public function crearVacante()
    {
        // valida el form
        $data = $this->validate();

        // almacenar la imagen
        $imagen = $this->imagen->store('public/vacantes');
        $data['imagen'] = str_replace('public/vacantes/', '', $imagen);

        // crear la vacante
        Vacante::create([
            'titulo' => $data['titulo'],
            'salario_id' => $data['salario'],
            'categoria_id' => $data['categoria'],
            'empresa' => $data['empresa'],
            'ultimo_dia' => $data['ultimo_dia'],
            'descripcion' => $data['descripcion'],
            'imagen' => $data['imagen'],
            'user_id' => auth()->user()->id
        ]);

        // mensaje al redireccionar
        session()->flash('mensaje', 'La vacante se publicó correctamente!');

        return redirect()->route('vacantes.index');
    }

    public function render()
    {
        // Consultar BD
        $salarios = Salario::all();
        $categorias = Categoria::all();

        return view('livewire.crear-vacante', [
            'salarios' => $salarios,
            'categorias' => $categorias,
        ]);
    }
}
