Olá, {{ $user->name }}!


Acesse o link abaixo para recuperar sua senha na área restrita {{ config('app.name') }}:

{{ $link }}


Após resetar sua senha, faça login com o nome de usuário {{ $user->username }}.


Se você não solicitou a recuperação de sua senha, ignorar esse e-mail.

Esse e-mail foi enviado automaticamente. Favor não responder.
