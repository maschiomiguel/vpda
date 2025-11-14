<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.username')
                ->type('text')
                ->required()
                ->title(__('Usuário'))
                ->placeholder(__('Usuário'))
                ->help("Será utilizado para logar no painel."),

            Input::make('user.email')
                ->type('email')
                ->title(__('Email'))
                ->placeholder(__('Email')),
        ];
    }
}
