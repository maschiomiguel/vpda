@extends('platform::dashboard')

@section('title')
    {{ __($name) }}
@endsection

@section('description')
    {{ __($description) }}
@endsection

@section('controller')
    base
@endsection

@php
    $methods = [
        'Voltar' => 'voltar',
        'Adicionar' => 'adicionar',
        'Remover Selecionados' => 'remover-selecionados',
    ];
@endphp

@if ($commandBar)

    {{-- Necessario verificação dessa variavel, caso contrario ira adicionar uma navbar sticky mesmo não tendo botão --}}
    @php
        $hasNavbarSticky = false;
    @endphp

    {{-- Faz um foreach nos botoes realocando o index de cada um pra ficar mais facil diferenciar --}}
    @foreach ($commandBar as $i => $command)
        @if (!in_array($command->slug, $methods))
            @php
                $hasNavbarSticky = true;
            @endphp
        @elseif(in_array($command->slug, $methods))
            @foreach($methods as $slug => $method)
                @if($command->slug === $method)
                    @php
                        $commandBar[$method] = $commandBar[$i];
                            unset($commandBar[$i]);
                    @endphp
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Botão voltar a esquerda da navbar --}}
    @if (isset($commandBar['voltar']))
        @section('navbar-back')
            <li class="">
                {!! $commandBar['voltar'] !!}
            </li>
        @endsection
    @endif

    {{-- Demais botöes alinhados a direita da navbar sticky --}}
    @if ($hasNavbarSticky)
        @section('navbar')
            @foreach ($commandBar as $command)
                @if ($command->slug !== 'voltar' && $command->slug !== 'adicionar' && $command->slug !== 'remover-selecionados')
                    <li class="">
                        {!! $command !!}
                    </li>
                @endif
            @endforeach
        @endsection
    @endif

    {{-- Botão adicionar na navbar do topo --}}
    @section('navbar-top')
        @if (isset($commandBar['remover-selecionados']))
            <li class="">
                {!! $commandBar['remover-selecionados'] !!}
            </li>
        @endif
        @if (isset($commandBar['adicionar']))
                <li class="">
                    {!! $commandBar['adicionar'] !!}
                </li>
        @endif
    @endsection

@endif

@section('content')
    <div id="modals-container">
        @stack('modals-container')
    </div>

    <form id="post-form" class="mb-md-4" method="post" enctype="multipart/form-data" data-controller="form" data-action="keypress->form#disableKey
                           form#submit" data-form-validation="{{ $formValidateMessage }}" novalidate>
        {!! $layouts !!}
        @csrf
        @include('platform::partials.confirm')
    </form>

    <div data-controller="filter">
        <form id="filters" autocomplete="off" data-action="filter#submit"></form>
    </div>
@endsection
