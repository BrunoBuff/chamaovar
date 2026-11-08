<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Um celular cadastrado por um usuário.
 * O token do aparelho fica guardado apenas como hash (coluna token_hash).
 */
#[Fillable(['name', 'token_hash', 'last_used_at'])]
#[Hidden(['token_hash'])]
class Device extends Model
{
    // Permite criar devices de teste com factory (vamos criar a factory no passo 7).
    use HasFactory;

    /**
     * Converte colunas do banco para tipos do PHP.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // Assim $device->last_used_at vira um objeto de data (Carbon), e não um texto.
            'last_used_at' => 'datetime',
        ];
    }

    /**
     * O usuário dono deste celular.
     * belongsTo porque a tabela devices tem a coluna user_id.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Os vídeos enviados por este celular.
     * hasMany porque a tabela videos tem a coluna device_id.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
