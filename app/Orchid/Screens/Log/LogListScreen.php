<?php

namespace App\Orchid\Screens\Log;

use App\Modules\ModulesScreen;
use Orchid\Screen\Screen;
use App\Models\Log;
use App\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Color;

class LogListScreen extends ModulesScreen
{
    protected $url_list = 'platform.systems.logs';

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'logs' => Log::orderByDesc('id')
                ->filters()
                ->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Lista de logs de usuários';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('filter.message')
                        ->type('text')
                        ->title("Ação")
                        ->value(request()->input('filter.message', '')),
                    
                    Select::make('filter.user_id')
                        ->title("Usuário")
                        ->fromModel(User::class, 'name', 'id')
                        ->empty(mb_chr(160), '')
                        ->value(request()->input('filter.user_id')),

                    Input::make('filter.created_at.start')
                        ->type('date')
                        ->title("Data inicial")
                        ->value(request()->input('filter.created_at.start', '')),
                    
                    Input::make('filter.created_at.end')
                        ->type('date')
                        ->title("Data final")
                        ->value(request()->input('filter.created_at.end', '')),
                ]),
                
                Group::make([
                    Button::make('Buscar')
                        ->method('searchRedirect')
                        ->icon('magnifier')
                        ->class('btn btn-default btn-primary'),

                    Button::make('Limpar filtros')
                        ->type(Color::LINK())
                        ->method('removeFilters')
                        ->icon('cross')
                        ->canSee($this->hasFilters()),
                ])->autoWidth(),
                
            ])->title('Filtrar logs'),

            Layout::table('logs', [
                TD::make("user_name", "Usuário"),// ->filter(Input::make()),
                TD::make("message", "Ação"),// ->filter(Input::make()),
                TD::make("created_at", "Data")->render(fn($e) => $e->created_at?->format('d/m/Y H:i')), // ->filter(DateRange::make()),
            ])->title('Lista de logs'),
        ];
    }
    
    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.systems.logs',
        ];
    }
}
