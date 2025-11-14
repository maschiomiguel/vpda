<?php

namespace Modules\Links\Orchid\Screens;

use Modules\Links\Models\Link;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\DropDown;
use App\Modules\ModulesScreen;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Support\Facades\Toast;

class LinkListScreen extends ModulesScreen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        checkAuth('platform.links.list');

        return [
            'lista' => Link::orderBy('order')
                ->paginate(777777),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Lista de links';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            parent::getCreateLink('platform.links.create'),
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
            Layout::table('lista', [
                TD::make()->sortable('links'),
                TD::make('checkbox', CheckBox::make('select-all')->class("form-check-input select-all-report-checks"))->checkbox('links'),
                TD::make("name", "Nome"),
                TD::make("active", "Ativo")->toggleActive('links'),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Link $model) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            parent::getEditButton($model, 'platform.links.edit', true),
                            parent::getRemoveButton($model, true),
                        ])),
            ]),
        ];
    }
    
    public function remove(Link $model)
    {
        return parent::delete($model, 'platform.links.list');
    }

    public function removeAll()
    {
        $ids = request()->input('select-all');
        $count = count($ids);

        foreach ($ids as $id) {
            $model = Link::where('id', $id);
            parent::delete($model->first(), '', true);
        }

        Toast::info(
            "$count links apagados"
        );

        return redirect()->route('platform.links.list');
    }

    public static function routes()
    {
        parent::routeList('links', 'links');
    }
    
    public static function permissions()
    {
        return parent::crudPermissions('links', 'links');
    }
    
    protected static function permissionSlug() : string
    {
        return 'links';
    }
}
