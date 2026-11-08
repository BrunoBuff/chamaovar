<?php

use App\Models\Device;
use App\Models\Video;

test('mantém o vídeo e esvazia o device_id quando o celular é apagado', function () {
    $device = Device::factory()->create();
    $video = Video::factory()->fromDevice($device)->create();

    $device->delete();

    // O vídeo continua no banco...
    $this->assertModelExists($video);
    // ...mas sem celular. fresh() relê o vídeo do banco, pois o objeto $video
    // na memória ainda tem o device_id antigo.
    expect($video->fresh()->device_id)->toBeNull();
});

test('apaga os vídeos quando o dono é apagado', function () {
    $video = Video::factory()->create();

    $video->user->delete();

    $this->assertModelMissing($video);
});

test('esconde o caminho do arquivo quando o vídeo vira JSON', function () {
    $video = Video::factory()->create();

    $json = $video->toArray();

    expect($json)->toHaveKey('title')->not->toHaveKey('path');
});
