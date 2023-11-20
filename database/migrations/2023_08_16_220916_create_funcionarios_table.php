<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_nasc');
            $table->enum('sexo', ['f', 'm', 'o']);
            $table->string('email')->unique();
            $table->string('telefone', 15);
            $table->char('cpf', 11)->unique();
            $table->date('data_contratacao');
            $table->date('data_desligamento')->nullable();
            $table->string('foto')->nullable();
            $table->decimal('salario', 10,2)->nullable();
            $table->foreignId('departamento_id')->constrained()->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('cargo_id')->constrained()->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('restrict');
            $table->enum('status', ['on', 'off']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
