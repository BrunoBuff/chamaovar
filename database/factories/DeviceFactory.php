<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Receita para criar celulares falsos nos testes.
 *
 * @extends Factory<Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Valores padrão de um celular de exemplo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // User::factory() cria um usuário novo para ser o dono,
            // a não ser que o teste informe um dono (ex.: ->for($user)).
            'user_id' => User::factory(),

            'name' => fake()->randomElement(['iPhone 15', 'Galaxy S24', 'Moto G84']),

            // Simula o que o sistema real vai fazer: gerar um token aleatório
            // e guardar só o hash SHA-256 dele (64 caracteres).
            'token_hash' => hash('sha256', Str::random(40)),

            // Celular novo: ainda não usou a API.
            'last_used_at' => null,
        ];
    }
}
