<p>{!! nl2br(e($bodyMessage)) !!}</p>

@if (! empty($empleados))
    <p>Perfiles enviados:</p>
    <ul>
        @foreach ($empleados as $empleado)
            <li>{{ $empleado->nombre_completo }} - {{ $empleado->correo }}</li>
        @endforeach
    </ul>
@endif
