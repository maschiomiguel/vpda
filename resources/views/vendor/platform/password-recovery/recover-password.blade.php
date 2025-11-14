@extends('platform::password-recovery')
@section('title',__('Recuperar senha'))

@section('content')

<form method="post">
    @csrf
    <div class="mb-3">

        <p>
            Preencha sua nova senha:
        </p>

        <label class="form-label">
            {{__('Nova senha')}}
        </label>

        {!!  \Orchid\Screen\Fields\Password::make('password')
            ->type('password')
            ->required()
            ->tabindex(1)
            ->autofocus()
            ->autocomplete('password')
            ->placeholder(__('Digite sua nova senha'))
        !!}
        
        <label class="form-label">
            {{__('Confirme a nova senha')}}
        </label>

        {!!  \Orchid\Screen\Fields\Password::make('password_confirm')
            ->type('password')
            ->required()
            ->tabindex(1)
            ->autofocus()
            ->autocomplete('password')
            ->placeholder(__('Confirme a nova senha'))
        !!}
    </div>

    <div class="row align-items-center">
        <div class="col-md-6 col-xs-12"></div>
        <div class="col-md-6 col-xs-12">
            <button type="submit" class="btn btn-default btn-block" tabindex="2">
                {{__('Resetar senha')}}
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
