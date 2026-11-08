<?php

use App\Models\Device;
use Illuminate\Database\UniqueConstraintViolationException;

test('apaga os celulares quando o dono é apagado', function () {
    $device = Device::factory()->create();

    $device->user->delete();

    // assertModelMissing: confere que o celular NÃO está mais no banco.
    $this->assertModelMissing($device);
});

test('recusa dois celulares com o mesmo hash de token', function () {
    $device = Device::factory()->create();

    // Guardamos a ação numa função (fn) para o Pest poder rodá-la e "pegar" o erro.
    $createDuplicate = fn () => Device::factory()->create(['token_hash' => $device->token_hash]);

    // O índice unique() da migration deve fazer o banco recusar o segundo celular.
    expect($createDuplicate)->toThrow(UniqueConstraintViolationException::class);
});

test('esconde o hash do token quando o celular vira JSON', function () {
    $device = Device::factory()->create();

    // toArray() é o que o Laravel usa por baixo para montar o JSON da API.
    $json = $device->toArray();

    expect($json)->toHaveKey('name')->not->toHaveKey('token_hash');
});
