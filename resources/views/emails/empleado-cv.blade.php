<p>Se comparte el CV de {{ $empleado->nombre_completo }}.</p>

<p>{!! nl2br(e($bodyMessage)) !!}</p>

<p>Datos de contacto:</p>
<ul>
    <li>Correo: {{ $empleado->correo }}</li>
    <li>Celular: {{ $empleado->celular }}</li>
</ul>
