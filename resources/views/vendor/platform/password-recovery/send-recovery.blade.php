@extends('platform::password-recovery')
@section('title',__('Enviar link de recuperação'))

@section('content')

<form method="post">
    @csrf
    <div class="mb-3">

        @if (session()->has('send-recover-status-success'))
            <div class="alert alert-success">
                {{ session('send-recover-status-success') }}
            </div>
        @endif

        <p>
            Preencha seu nome de usuário ou e-mail e um link de recuperação será enviado para o seu e-mail:
        </p>

        <label class="form-label">
            {{__('Usuário ou e-mail')}}
        </label>

        {!!  \Orchid\Screen\Fields\Input::make('username_or_email')
            ->type('text')
            ->required()
            ->tabindex(1)
            ->autofocus()
            ->autocomplete('username')
            ->inputmode('text')
            ->placeholder(__('Digite seu usuário ou e-mail'))
        !!}
    </div>

    <div class="row align-items-center">
        <div class="col-md-6 col-xs-12"></div>
        <div class="col-md-6 col-xs-12">
            <button type="submit" class="btn btn-default btn-block" tabindex="2">
                {{__('Enviar recuperação')}}
            </button>
        </div>
    </div>

</form>

<div class="row align-items-center">
    <div class="col-md-12 col-xs-12 pt-2">
        <a href="{{ route('platform.login') }}">
            Voltar ao login
        </a>
    </div>
</div>

@endsection
