<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('servidor_portarias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('numeroPortaria');
            $table->foreign('numeroPortaria')->references('numeroPortaria')->on('portarias');
            $table->bigInteger('matriculaSiape');
            $table->foreign('matriculaSiape')->references('matriculaSiape')->on('users');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servidor_portarias');
    }
};
