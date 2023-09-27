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

        Schema::create('portarias', function (Blueprint $table) {
            $table->bigInteger('numeroPortaria');
            $table->date('dataCriacao');
            $table->date('dataEncerramento')->nullable();
            $table->string('descricao', 300);
            $table->boolean('isPrivate');
            $table->string('arquivo')->nullable();
            $table->timestamps();
            $table->primary('numeroPortaria');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portarias');
    }
};
