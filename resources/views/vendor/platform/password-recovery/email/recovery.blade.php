<!DOCTYPE HTML>
<html>
    <head></head>
    <body>
        <p>
            Olá, {{ $user->name }}!
        </p>
        <p>
            Clique no link abaixo para recuperar sua senha na área restrita {{ config('app.name') }}:
        </p>
        <p>
            <a href="{{ $link }}" target="_blank">
                {{ $link }}
            </a>
        </p>
        <p>
            Após resetar sua senha, faça login com o nome de usuário <strong>{{ $user->username }}</strong>.
        </p>
        <p>
            <i>Se você não solicitou a recuperação de sua senha, ignorar esse e-mail.</i>
        </p>
        <p>
            <i>Esse e-mail foi enviado automaticamente. Favor não responder.</i>
        </p>
    </body>
</html>
