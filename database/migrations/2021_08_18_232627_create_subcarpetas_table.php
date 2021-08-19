<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Carpeta;

class CreateSubcarpetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcarpetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ruta')->nullable();
            $table->boolean('activo')->default(1);
            $table->foreignIdFor(Carpeta::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcarpetas');
    }
}