<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegistroController extends Controller
{
    public function create()
    {
        $areas = Area::with('subareas')->orderBy('nombre_area')->get();

        return view('bolsa.registro.form', compact('areas'));
    }

    public function store(Request $request)
    {
        $messages = [
            'email.unique' => 'El correo ya existe en nuestros registros.',
        ];

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:60'],
            'paterno' => ['required', 'string', 'max:60'],
            'materno' => ['nullable', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:100', 'unique:empleados,correo'],
            'telefono' => ['required', 'string', 'max:20'],
            'edad' => ['required', 'integer', 'between:18,99'],
            'estudios' => ['required', 'in:primaria,secundaria,preparatoria,universidad,maestria,doctorado'],
            'experiencia' => ['required', 'in:Sin experiencia,0-1 años de experiencia,1-5 años de experiencia,mas de 5 años de experiencia'],
            'dispuesto' => ['required', 'in:si,no'],
            'curriculum' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'subareas' => ['nullable', 'array', 'max:3'],
            'subareas.*' => ['integer', 'exists:subareas,id_subarea'],
            'sugerencia' => ['nullable', 'string', 'max:255'],
        ]);

        $ruta = $this->storeCurriculum($request->file('curriculum'), $data['nombre'], $data['paterno']);

        $subareas = $data['subareas'] ?? [];
        if (empty($subareas) && empty(trim($data['sugerencia'] ?? ''))) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['subareas' => 'Selecciona al menos una subárea o ingresa una sugerencia.']);
        }
        $hasSuggestion = !empty(trim($data['sugerencia'] ?? ''));

        $registro = Empleado::create([
            'nombre_completo' => trim("{$data['nombre']} {$data['paterno']} {$data['materno']}"),
            'celular' => $data['telefono'],
            'correo' => $data['email'],
            'estudios' => $data['estudios'],
            'edad' => $data['edad'],
            'ruta_curriculum' => $ruta,
            'experiencia' => $data['experiencia'],
            'area1' => $subareas[0] ?? null,
            'area2' => $subareas[1] ?? null,
            'area3' => $subareas[2] ?? null,
            'dispuesto' => $data['dispuesto'],
            'fecha_registro' => now(),
            'sugerencia' => $data['sugerencia'] ?? '',
            'asignado' => $hasSuggestion ? 'no' : 'si',
        ]);

        return redirect()->route('bolsa.registro.success');
    }

    public function success()
    {
        return view('bolsa.registro.success');
    }

    private function storeCurriculum($file, string $nombre, string $paterno): string
    {
        $slug = Str::slug("{$nombre}-{$paterno}");
        $filename = "{$slug}-" . Str::orderedUuid() . '.pdf';

        $path = Storage::putFileAs('curriculums', $file, $filename);

        return basename($path);
    }
}
