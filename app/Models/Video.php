<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Um vídeo de lance enviado por um usuário.
 * O arquivo fica no storage privado; o banco guarda só o caminho (coluna path).
 */
#[Fillable(['title', 'path', 'original_name', 'mime_type', 'size'])]
#[Hidden(['path'])]
class Video extends Model
{
    // Permite criar vídeos de teste com factory (vamos criar a factory no passo 7).
    use HasFactory;

    /**
     * Converte colunas do banco para tipos do PHP.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // Garante que o tamanho venha como número, e não como texto.
            'size' => 'integer',
        ];
    }

    /**
     * O usuário dono deste vídeo.
     * belongsTo porque a tabela videos tem a coluna user_id.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * O celular que enviou este vídeo (pode ser null se veio pelo upload web).
     * belongsTo porque a tabela videos tem a coluna device_id.
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
