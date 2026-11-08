# ChamaoVar 🟥

Um "VAR" para os seus lances esportivos.

Deixe o celular gravando o jogo pelo navegador e, quando acontecer um lance, toque em **"CHAMA O VAR"**: os **últimos 10 segundos antes do clique** viram um replay salvo na sua conta. Só você vê os seus replays.

> Projeto de estudo/hobby em Laravel, em desenvolvimento.

## Como vai funcionar

1. Você cria uma conta e faz login.
2. No celular, abre o **Modo câmera** do site. A câmera fica gravando sem parar, guardando só os segundos mais recentes.
3. Aconteceu o lance? Toque em **"CHAMA O VAR"**. O trecho é enviado automaticamente, sem escolher arquivo.
4. O servidor corta exatamente os **últimos 10 segundos** e salva o replay na sua conta.
5. No painel, você assiste aos seus replays. Os vídeos ficam guardados em área privada e só o dono tem acesso.

Também será possível:

- enviar um vídeo pelo **upload web** (ele é cortado da mesma forma);
- usar um **celular fixo no campo** (num tripé, por exemplo), autenticado por um token próprio do aparelho, sem precisar do login de uma pessoa.

## Andamento

| Etapa | Status |
|---|---|
| 1. Banco de dados: tabelas, models, factories e testes | ✅ Concluída |
| 2. Upload web, painel e reprodução (só o dono assiste) | ⏳ Próxima |
| 3. Corte automático dos últimos 10 segundos (FFmpeg) | ⏳ |
| 4. Modo câmera no navegador + botão "CHAMA O VAR" | ⏳ |
| 5. Cadastro de celulares com token | ⏳ |

## Tecnologias

- [Laravel 13](https://laravel.com) com [Breeze](https://laravel.com/docs/starter-kits) (Blade)
- PHP 8.3
- SQLite
- [Pest](https://pestphp.com) para os testes
- [FFmpeg](https://ffmpeg.org) para cortar os vídeos (a partir da etapa 3)

## Como rodar na sua máquina

Pré-requisitos: PHP 8.3, Composer e Node.js (no Windows, o [Laragon](https://laragon.org) já traz tudo isso).

```bash
# 1. Baixar o projeto
git clone https://github.com/BrunoBuff/chamaovar.git
cd chamaovar

# 2. Instalar dependências, criar o .env, gerar a chave, criar as tabelas e compilar o front
composer run setup

# 3. Subir o servidor de desenvolvimento
composer run dev
```

O banco é SQLite, guardado em `database/database.sqlite`. Se durante o `setup` o terminal perguntar se quer criar esse arquivo, responda `yes`.

## Testes

```bash
php artisan test
```

Os testes usam um banco SQLite em memória, então nunca mexem nos seus dados.

## Segurança

- Os vídeos ficam fora da pasta pública (`storage/app/private`) e são entregues por um controller que confere se quem pede é o dono.
- O token de cada celular é mostrado uma única vez; o banco guarda apenas o hash (SHA-256) dele.

## Licença

Projeto pessoal de estudo, distribuído sob a licença [MIT](https://opensource.org/licenses/MIT).
