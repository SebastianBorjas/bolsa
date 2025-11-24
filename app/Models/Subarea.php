<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subarea extends Model
{
    use HasFactory;

    protected $table = 'subareas';
    protected $primaryKey = 'id_subarea';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_area',
        'nombre_subarea',
        'descripcion',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'area1', 'id_subarea');
    }
}
