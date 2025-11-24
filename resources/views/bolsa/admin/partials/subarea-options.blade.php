<option value="" class="bg-white text-slate-900">Todas las subáreas</option>
@foreach ($subareas as $subarea)
    <option value="{{ $subarea->id_subarea }}" class="bg-white text-slate-900" @selected($selectedSubarea == $subarea->id_subarea)>
        {{ optional($subarea->area)->nombre_area ?? 'Área desconocida' }} · {{ $subarea->nombre_subarea }}
    </option>
@endforeach
