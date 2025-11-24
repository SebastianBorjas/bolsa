<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';
    protected $primaryKey = 'id_area';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'nombre_area',
    ];

    public function subareas()
    {
        return $this->hasMany(Subarea::class, 'id_area', 'id_area');
    }
}
