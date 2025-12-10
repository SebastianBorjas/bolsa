<?php

namespace App\Http\Controllers;

use App\Mail\EmpleadoCvMail;
use App\Mail\EmpleadosBulkCvMail;
use App\Models\Area;
use App\Models\Empleado;
use App\Models\Subarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BolsaController extends Controller
{
    public function index(Request $request)
    {
        if (! Auth::check()) {
            return view('bolsa.admin.login');
        }

        return view('bolsa.admin.dashboard', $this->buildDashboardData($request, true));
    }

    public function empleados(Request $request)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $assigned = $request->query('assigned', '1') !== '0';
        $data = $this->buildDashboardData($request, $assigned);

        $tablePartial = $assigned
            ? 'bolsa.admin.partials.empleados-content'
            : 'bolsa.admin.partials.sugerencias-table';

        return response()->json([
            'content' => view($tablePartial, $data)->render(),
            'subareas' => view('bolsa.admin.partials.subarea-options', $data)->render(),
        ]);
    }

    private function buildDashboardData(Request $request, bool $assigned = true): array
    {
        $selectedArea = $request->query('area');
        $selectedSubarea = $request->query('subarea');
        $search = $request->query('search');
        $order = $request->query('order', 'fecha_desc');

        $areas = Area::with(['subareas' => fn ($query) => $query->orderBy('nombre_subarea')])
            ->orderBy('nombre_area')
            ->get();
        $subareas = $selectedArea
            ? Subarea::with('area')->where('id_area', $selectedArea)->orderBy('nombre_subarea')->get()
            : collect();

        $empleadosQuery = Empleado::with([
            'primaryArea.area',
            'secondaryArea.area',
            'tertiaryArea.area',
        ])
            ->where('asignado', $assigned ? 'si' : 'no');

        if ($selectedArea) {
            $subareaIds = Subarea::where('id_area', $selectedArea)->pluck('id_subarea')->all();
            if (! empty($subareaIds)) {
                $empleadosQuery->where(function ($query) use ($subareaIds) {
                    $query->whereIn('area1', $subareaIds)
                        ->orWhereIn('area2', $subareaIds)
                        ->orWhereIn('area3', $subareaIds);
                });
            }
        }

        if ($selectedSubarea) {
            $empleadosQuery->where(function ($query) use ($selectedSubarea) {
                $query->where('area1', $selectedSubarea)
                    ->orWhere('area2', $selectedSubarea)
                    ->orWhere('area3', $selectedSubarea);
            });
        }

        if ($search) {
            $empleadosQuery->where(function ($query) use ($search) {
                $query->where('nombre_completo', 'like', "%{$search}%")
                    ->orWhere('correo', 'like', "%{$search}%");
            });
        }

        if ($order === 'nombre_asc') {
            $empleadosQuery->orderBy('nombre_completo');
        } else {
            $empleadosQuery->orderByDesc('fecha_registro');
        }

        if ($assigned) {
            $empleados = $empleadosQuery->paginate(30);
        } else {
            $empleados = $empleadosQuery->get();
        }

        return compact(
            'areas',
            'subareas',
            'empleados',
            'selectedArea',
            'selectedSubarea',
            'search',
            'order'
        );
    }

    public function updateEmpleado(Request $request, Empleado $empleado)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $validated = $request->validate([
            'nombre_completo' => ['required', 'string', 'max:120'],
            'celular' => ['required', 'string', 'max:20'],
            'correo' => ['required', 'email', 'max:100'],
            'edad' => ['required', 'integer', 'between:18,99'],
            'estudios' => ['required', 'in:primaria,secundaria,preparatoria,universidad,maestria,doctorado'],
            'experiencia' => ['required', 'in:Sin experiencia,0-1 años de experiencia,1-5 años de experiencia,mas de 5 años de experiencia'],
            'dispuesto' => ['required', 'in:si,no'],
            'curriculum' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'subareas' => ['nullable', 'array', 'max:3'],
            'subareas.*' => ['integer', 'exists:subareas,id_subarea'],
            'sugerencia' => ['nullable', 'string', 'max:255'],
        ]);

        $chosenSubareas = array_values(array_filter($validated['subareas'] ?? [], fn ($value) => $value !== null && $value !== ''));
        $sugerenciaValue = array_key_exists('sugerencia', $validated)
            ? $validated['sugerencia']
            : ($empleado->sugerencia ?? '');
        $hasSuggestion = ! empty(trim($sugerenciaValue ?? ''));

        if (empty($chosenSubareas) && ! $hasSuggestion) {
            return redirect()->route('bolsa.index')
                ->with('error', 'Selecciona al menos una subárea o agrega una sugerencia antes de guardar.');
        }

        $payload = [
            'nombre_completo' => $validated['nombre_completo'],
            'celular' => $validated['celular'],
            'correo' => $validated['correo'],
            'edad' => $validated['edad'],
            'estudios' => $validated['estudios'],
            'experiencia' => $validated['experiencia'],
            'dispuesto' => $validated['dispuesto'],
            'sugerencia' => $sugerenciaValue,
            'area1' => $chosenSubareas[0] ?? null,
            'area2' => $chosenSubareas[1] ?? null,
            'area3' => $chosenSubareas[2] ?? null,
        ];

        if ($request->hasFile('curriculum')) {
            if ($empleado->ruta_curriculum) {
                Storage::disk('local')->delete("curriculums/{$empleado->ruta_curriculum}");
            }
            $payload['ruta_curriculum'] = $this->storeCurriculumFile($request->file('curriculum'), $validated['nombre_completo']);
        }

        $empleado->update($payload);

        return redirect()->route('bolsa.index')->with('status', 'Registro actualizado correctamente.');
    }

    public function destroyEmpleado(Empleado $empleado)
    {
        if (! Auth::check()) {
            abort(403);
        }

        if ($empleado->ruta_curriculum) {
            Storage::disk('local')->delete("curriculums/{$empleado->ruta_curriculum}");
        }

        $empleado->delete();

        return redirect()->route('bolsa.index')->with('status', 'Registro eliminado correctamente.');
    }

    public function reassignEmpleado(Request $request, Empleado $empleado)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $validated = $request->validate([
            'subareas' => ['required', 'array', 'max:3'],
            'subareas.*' => ['integer', 'exists:subareas,id_subarea'],
        ]);

        $chosenSubareas = array_values(array_filter($validated['subareas'], fn ($value) => $value !== null && $value !== ''));

        if (empty($chosenSubareas)) {
            return redirect()->route('bolsa.sugerencias')->with('error', 'Selecciona al menos una subárea antes de reasignar.');
        }

        $empleado->update([
            'area1' => $chosenSubareas[0] ?? null,
            'area2' => $chosenSubareas[1] ?? null,
            'area3' => $chosenSubareas[2] ?? null,
            'asignado' => 'si',
        ]);

        return redirect()->route('bolsa.sugerencias')->with('status', 'Registro reasignado correctamente.');
    }

    public function sendCv(Request $request, Empleado $empleado)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $validated = $request->validate([
            'destinatario' => ['required', 'email'],
            'asunto' => ['required', 'string', 'max:150'],
            'mensaje' => ['required', 'string', 'max:2000'],
        ]);

        $relativePath = $empleado->ruta_curriculum ? "curriculums/{$empleado->ruta_curriculum}" : null;
        $disk = Storage::disk('local');

        if (! $relativePath || ! $disk->exists($relativePath)) {
            return response()->json([
                'message' => 'Este registro no tiene curriculum adjunto.',
            ], 422);
        }

        $attachmentPath = $disk->path($relativePath);

        Mail::to($validated['destinatario'])->send(new EmpleadoCvMail(
            $empleado,
            $validated['asunto'],
            $validated['mensaje'],
            $attachmentPath
        ));

        return response()->json([
            'message' => 'Correo enviado correctamente.',
        ]);
    }

    public function sendMultiple(Request $request)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $validated = $request->validate([
            'destinatario' => ['required', 'email'],
            'asunto' => ['required', 'string', 'max:150'],
            'mensaje' => ['required', 'string', 'max:2000'],
            'empleados' => ['required', 'array', 'min:1', 'max:100'],
            'empleados.*' => ['integer', 'exists:empleados,id_empleado'],
        ]);

        $empleados = Empleado::whereIn('id_empleado', $validated['empleados'])
            ->whereNotNull('ruta_curriculum')
            ->get();

        if ($empleados->isEmpty()) {
            return response()->json([
                'message' => 'Ninguno de los registros seleccionados tiene curriculum adjunto.',
            ], 422);
        }

        $disk = Storage::disk('local');
        $attachments = [];
        foreach ($empleados as $empleado) {
            $relativePath = "curriculums/{$empleado->ruta_curriculum}";
            if ($disk->exists($relativePath)) {
                $attachments[] = $disk->path($relativePath);
            }
        }

        if (empty($attachments)) {
            return response()->json([
                'message' => 'No se encontraron archivos PDF para los registros seleccionados.',
            ], 422);
        }

        Mail::to($validated['destinatario'])->send(new EmpleadosBulkCvMail(
            $empleados->all(),
            $validated['asunto'],
            $validated['mensaje'],
            $attachments
        ));

        return response()->json([
            'message' => 'Correos enviados correctamente.',
        ]);
    }

    public function areas()
    {
        if (! Auth::check()) {
            return redirect()->route('bolsa.index');
        }

        $areas = Area::with('subareas')->orderBy('nombre_area')->get();

        return view('bolsa.admin.areas', compact('areas'));
    }

    public function storeArea(Request $request)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $data = $request->validate([
            'nombre_area' => ['required', 'string', 'max:100', 'unique:areas,nombre_area'],
        ]);

        Area::create(['nombre_area' => trim($data['nombre_area'])]);

        return redirect()->route('bolsa.areas')->with('status', 'Área creada correctamente.');
    }

    public function storeSubarea(Request $request)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $data = $request->validate([
            'area_id' => ['required', 'integer', 'exists:areas,id_area'],
            'nombre_subarea' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        Subarea::create([
            'id_area' => $data['area_id'],
            'nombre_subarea' => trim($data['nombre_subarea']),
            'descripcion' => trim($data['descripcion'] ?? ''),
        ]);

        return redirect()->route('bolsa.areas')->with('status', 'Subárea registrada correctamente.');
    }

    public function sugerencias(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('bolsa.index');
        }

        $data = $this->buildDashboardData($request, false);

        return view('bolsa.admin.sugerencias', $data);
    }

    public function updateArea(Request $request, Area $area)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $data = $request->validate([
            'nombre_area' => ['required', 'string', 'max:100', 'unique:areas,nombre_area,' . $area->id_area . ',id_area'],
        ]);

        $area->update(['nombre_area' => trim($data['nombre_area'])]);

        return redirect()->route('bolsa.areas')->with('status', 'Área actualizada correctamente.');
    }

    public function destroyArea(Area $area)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $area->subareas()->delete();
        $area->delete();

        return redirect()->route('bolsa.areas')->with('status', 'Área eliminada correctamente.');
    }

    public function updateSubarea(Request $request, Subarea $subarea)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $data = $request->validate([
            'area_id' => ['required', 'integer', 'exists:areas,id_area'],
            'nombre_subarea' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        $subarea->update([
            'id_area' => $data['area_id'],
            'nombre_subarea' => trim($data['nombre_subarea']),
            'descripcion' => trim($data['descripcion'] ?? ''),
        ]);

        return redirect()->route('bolsa.areas')->with('status', 'Subárea actualizada correctamente.');
    }

    public function destroySubarea(Subarea $subarea)
    {
        if (! Auth::check()) {
            abort(403);
        }

        $subarea->delete();

        return redirect()->route('bolsa.areas')->with('status', 'Subárea eliminada correctamente.');
    }

    private function storeCurriculumFile($file, string $label): string
    {
        $slug = Str::slug($label ?: 'empleado');
        $filename = "{$slug}-" . Str::orderedUuid() . '.pdf';

        $path = Storage::putFileAs('curriculums', $file, $filename);

        return basename($path);
    }

    public function previewCurriculum(Empleado $empleado)
    {
        if (! Auth::check()) {
            abort(403);
        }

        return $this->curriculumResponse($empleado);
    }

    public function downloadCurriculum(Empleado $empleado)
    {
        if (! Auth::check()) {
            abort(403);
        }

        return $this->curriculumResponse($empleado, true);
    }

    private function curriculumResponse(Empleado $empleado, bool $forceDownload = false)
    {
        $filename = $empleado->ruta_curriculum;
        if (! $filename) {
            abort(404);
        }

        $disk = Storage::disk('local');
        $relativePath = "curriculums/{$filename}";

        if (! $disk->exists($relativePath)) {
            abort(404);
        }

        if ($forceDownload) {
            return $disk->download($relativePath, $filename, ['Content-Type' => 'application/pdf']);
        }

        return response()->file($disk->path($relativePath), ['Content-Type' => 'application/pdf']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('bolsa.index');
        }

        return back()->withErrors([
            'email' => 'Estas credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('bolsa.index');
    }
}
