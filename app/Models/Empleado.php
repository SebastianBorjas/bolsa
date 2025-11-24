<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'nombre_completo',
        'celular',
        'correo',
        'estudios',
        'edad',
        'ruta_curriculum',
        'experiencia',
        'area1',
        'area2',
        'area3',
        'dispuesto',
        'fecha_registro',
        'sugerencia',
        'asignado',
    ];

    protected $casts = [
        'fecha_registro' => 'date',
    ];

    public function primaryArea()
    {
        return $this->belongsTo(Subarea::class, 'area1', 'id_subarea');
    }

    public function secondaryArea()
    {
        return $this->belongsTo(Subarea::class, 'area2', 'id_subarea');
    }

    public function tertiaryArea()
    {
        return $this->belongsTo(Subarea::class, 'area3', 'id_subarea');
    }
}
