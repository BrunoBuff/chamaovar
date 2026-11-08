<?php

use App\Models\User;
use App\Models\Video;

test('lista só os vídeos que pertencem ao usuário', function () {
    $owner = User::factory()->create();
    $ownVideo = Video::factory()->for($owner)->create();
    // Vídeo de OUTRO usuário (a factory cria um dono novo). Ele não pode aparecer na lista.
    $otherUsersVideo = Video::factory()->create();

    $videos = $owner->videos;

    // modelKeys() devolve só os ids. Esperamos exatamente o id do vídeo do dono.
    expect($videos->modelKeys())->toBe([$ownVideo->id]);
});
