<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id_empleado');
            $table->string('nombre_completo', 100);
            $table->string('celular', 15);
            $table->string('correo', 100)->nullable();
            $table->enum('estudios', ['primaria', 'secundaria', 'preparatoria', 'universidad', 'maestria', 'doctorado']);
            $table->integer('edad');
            $table->string('ruta_curriculum', 255)->nullable();
            $table->enum(
                'experiencia',
                ['Sin experiencia', '0-1 años de experiencia', '1-5 años de experiencia', 'mas de 5 años de experiencia']
            );
            $table->unsignedInteger('area1')->nullable();
            $table->unsignedInteger('area2')->nullable();
            $table->unsignedInteger('area3')->nullable();
            $table->enum('dispuesto', ['si', 'no'])->default('no');
            $table->date('fecha_registro')->default(DB::raw('CURRENT_DATE'));
            $table->string('sugerencia', 255)->nullable();
            $table->enum('asignado', ['si', 'no'])->default('si');

            $table->unique('correo');
            $table->index('area1');
            $table->index('area2');
            $table->index('area3');

            $table->foreign('area1')->references('id_subarea')->on('subareas');
            $table->foreign('area2')->references('id_subarea')->on('subareas');
            $table->foreign('area3')->references('id_subarea')->on('subareas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
}
