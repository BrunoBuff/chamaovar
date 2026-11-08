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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();

            // Dono do celular, constrained() cria a chave estrangeira para users.id.
            // cascadeOnDelete(): se o usuário for apagado, os celulares dele também são.
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Apelido do aparelho para o usuário reconhecer na lista.
            $table->string('name');

            // Hash SHA-256 do token (sempre 64 caracteres em hexadecimal).
            // unique() impede dois aparelhos com o mesmo token e cria um índice,
            // o que deixa rápida a busca "qual device tem este token?" na API.
            $table->string('token_hash', 64)->unique();

            // Último uso da API. nullable() porque um aparelho novo ainda não usou.
            $table->timestamp('last_used_at')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
