<?php

namespace Modules\Galleries\Orchid\Screens\Galleries;

use Modules\Galleries\Models\Gallery;
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

class GalleryListScreen extends ModulesScreen
{
    protected $url_list = 'platform.galleries.list';

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        checkAuth('platform.galleries.list');

        return [
            'lista' => Gallery::orderBy('name')
                ->with('categories')
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
        return 'Lista de posts';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            parent::getCreateLink('platform.galleries.create'),
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
                
            // ])->title('Filtrar posts'),
            
            Layout::table('lista', [
                TD::make('checkbox', CheckBox::make('select-all')->class("form-check-input select-all-report-checks"))->checkbox('galleries'),
                TD::make("name", "Nome"),
                // TD::make("categories", "Categoria")->relationsBadge("primary"),
                TD::make("active", "Ativo")->toggleActive('galleries'),
                // TD::make("featured", "Destaque")->toggleFeatured('galleries'),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Gallery $model) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            parent::getEditButton($model, 'platform.galleries.edit', true),
                            parent::getRemoveButton($model, true),
                        ])),
            ])->title('Lista de posts'),
        ];
    }
    
    public function remove(Gallery $model)
    {
        return parent::delete($model, 'platform.galleries.list');
    }

    public function removeAll()
    {
        $ids = request()->input('select-all');
        $count = count($ids);

        foreach ($ids as $id) {
            $model = Gallery::where('id', $id);
            parent::delete($model->first(), '', true);
        }

        if ($count === 0) {
            return redirect()->route('platform.galleries.list');
        }

        Toast::info(
            "Foram removidas {$count} posts com sucesso."
        );

        return redirect()->route('platform.galleries.list');
    }

    public static function routes()
    {
        parent::routeList('posts', 'galleries');
    }
    
    public static function permissions()
    {
        return parent::crudPermissions('posts', 'galleries');
    }
    
    public static function metricsQuery()
    {
        return [
            'galleries' => Gallery::count(),
        ];
    }
    
    public static function metricsLayout()
    {
        return [
            'Total de posts' => 'metrics.galleries',
        ];
    }
    
    protected static function permissionSlug() : string
    {
        return 'galleries';
    }
}
