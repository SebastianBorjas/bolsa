<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    public function up(): void
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id_area');
            $table->string('nombre_area', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
}
