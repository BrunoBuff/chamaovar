<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de vídeos.
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            // Dono do vídeo. É esta coluna que o controller confere antes de liberar o arquivo.
            // cascadeOnDelete(): se o usuário for apagado, os vídeos dele também são.
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Celular que enviou o vídeo. É opcional (nullable) porque o upload web não usa device.
            // nullOnDelete(): se o celular for apagado, o vídeo continua e só o device_id fica vazio.
            // Atenção: nullable() precisa vir ANTES de constrained().
            $table->foreignId('device_id')->nullable()->constrained()->nullOnDelete();

            // Título opcional dado pelo usuário.
            $table->string('title')->nullable();

            // Caminho do arquivo dentro do storage privado (ex.: videos/1/abc123.mp4).
            // O vídeo em si NÃO fica no banco, só o endereço dele.
            $table->string('path');

            // Nome original do arquivo, como estava no celular.
            $table->string('original_name');

            // Tipo do arquivo (ex.: video/mp4), usado ao enviar o vídeo para o navegador.
            $table->string('mime_type');

            // Tamanho em bytes. unsignedBigInteger porque vídeo pode passar de 2 GB
            // e um tamanho nunca é negativo.
            $table->unsignedBigInteger('size');

            $table->timestamps();
        });
    }

    /**
     * Desfaz a migration (usado no rollback): apaga a tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
