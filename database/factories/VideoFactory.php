<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Receita para criar vídeos falsos nos testes.
 *
 * @extends Factory<Video>
 */
class VideoFactory extends Factory
{
    /**
     * Valores padrão de um vídeo de exemplo.
     * Por padrão, o vídeo veio pelo upload web (sem celular).
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'device_id' => null,
            'title' => fake()->sentence(3),

            // Só um caminho de exemplo: nenhum arquivo de verdade é criado.
            'path' => 'videos/'.Str::uuid().'.mp4',

            // numerify troca cada # por um número aleatório (ex.: VID_20261108.mp4).
            'original_name' => 'VID_'.fake()->numerify('########').'.mp4',
            'mime_type' => 'video/mp4',

            // Entre 1 MB e 50 MB, em bytes.
            'size' => fake()->numberBetween(1_000_000, 50_000_000),
        ];
    }

    /**
     * Estado "enviado por um celular".
     * Uso: Video::factory()->fromDevice($device)->create()
     *
     * O dono do vídeo passa a ser o mesmo dono do celular,
     * assim nunca criamos um vídeo de um usuário vindo do celular de outro.
     */
    public function fromDevice(Device $device): static
    {
        return $this->state(fn (array $attributes) => [
            'device_id' => $device->id,
            'user_id' => $device->user_id,
        ]);
    }
}
