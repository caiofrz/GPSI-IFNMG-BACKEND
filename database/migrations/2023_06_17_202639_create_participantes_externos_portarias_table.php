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

        Schema::create('membro_externo_portarias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('numeroPortaria');
            $table->foreign('numeroPortaria')->references('numeroPortaria')->on('portarias');
            $table->bigInteger('idMembroExterno');
            // $table->foreign('idMembroExterno')->references('id')->on('membros_externos');
            $table->timestamps();

        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membro_externo_portarias');
    }
};
