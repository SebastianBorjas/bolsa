<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubareasTable extends Migration
{
    public function up(): void
    {
        Schema::create('subareas', function (Blueprint $table) {
            $table->increments('id_subarea');
            $table->unsignedInteger('id_area');
            $table->string('nombre_subarea', 100);
            $table->string('descripcion', 255)->nullable();

            $table->foreign('id_area')
                ->references('id_area')
                ->on('areas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subareas');
    }
}
