<?php

namespace Modules\Videos\Orchid\Screens\Videos;

use Modules\Videos\Models\Video;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use App\Modules\ModulesScreen;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Color;
use Orchid\Support\Facades\Toast;

class VideoListScreen extends ModulesScreen
{
    protected $url_list = 'platform.videos.list';

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        checkAuth('platform.videos.list');

        return [
            'lista' => Video::orderBy('name')
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
        return 'Lista de videos';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            parent::getCreateLink('platform.videos.create'),
            parent::getRemoveSelectedButton(),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            // Layout::rows([
            //     Group::make([
            //         Input::make('filter.name')
            //             ->type('text')
            //             ->title("Nome")
            //             ->value(request()->input('filter.name', '')),
            //     ]),
                
            //     Group::make([
            //         Button::make('Buscar')
            //             ->method('searchRedirect')
            //             ->icon('magnifier')
            //             ->class('btn btn-default btn-primary'),

            //         Button::make('Limpar filtros')
            //             ->type(Color::LINK())
            //             ->method('removeFilters')
            //             ->icon('cross')
            //             ->canSee($this->hasFilters()),
            //     ])->autoWidth(),
                
            // ])->title('Filtrar videos'),
            
            Layout::table('lista', [
                TD::make('checkbox', CheckBox::make('select-all')->class("form-check-input select-all-report-checks"))->checkbox('videos'),
                TD::make("name", "Nome"),
                // TD::make("categories", "Categoria")->relationsBadge("primary"),
                TD::make("active", "Ativo")->toggleActive('videos'),
                // TD::make("featured", "Destaque")->toggleFeatured('videos'),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Video $model) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            parent::getEditButton($model, 'platform.videos.edit', true),
                            parent::getRemoveButton($model, true),
                        ])),
            ])->title('Lista de videos'),
        ];
    }
    
    public function remove(Video $model)
    {
        return parent::delete($model, 'platform.videos.list');
    }

    public function removeAll()
    {
        $ids = request()->input('select-all');
        $count = count($ids);

        foreach ($ids as $id) {
            $model = Video::where('id', $id);
            parent::delete($model->first(), '', true);
        }

        if ($count === 0) {
            return redirect()->route('platform.videos.list');
        }

        Toast::info(
            "Foram removidas {$count} videos com sucesso."
        );

        return redirect()->route('platform.videos.list');
    }

    public static function routes()
    {
        parent::routeList('videos', 'videos');
    }
    
    public static function permissions()
    {
        return parent::crudPermissions('videos', 'videos');
    }
    
    public static function metricsQuery()
    {
        return [
            'videos' => Video::count(),
        ];
    }
    
    public static function metricsLayout()
    {
        return [
            'Total de videos' => 'metrics.videos',
        ];
    }
    
    protected static function permissionSlug() : string
    {
        return 'videos';
    }
}
