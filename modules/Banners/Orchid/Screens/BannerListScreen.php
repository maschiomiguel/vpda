<?php

namespace Modules\Banners\Orchid\Screens;

use Modules\Banners\Models\Banner;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\DropDown;
use App\Modules\ModulesScreen;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Support\Facades\Toast;

class BannerListScreen extends ModulesScreen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        checkAuth('platform.banners.list');

        return [
            'lista' => Banner::orderBy('order')
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
        return 'Lista de banners';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            parent::getCreateLink('platform.banners.create'),
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
                TD::make()->sortable('banners'),
                TD::make('checkbox', CheckBox::make('select-all')->class("form-check-input select-all-report-checks"))->checkbox('banners'),
                TD::make("name", "Nome"),
                TD::make("active", "Ativo")->toggleActive('banners'),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Banner $model) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            parent::getEditButton($model, 'platform.banners.edit', true),
                            parent::getDuplicateteButton($model, 'platform.banners.edit', true),
                            parent::getRemoveButton($model, true),
                        ])),
            ]),
        ];
    }
    
    public function remove(Banner $model)
    {
        return parent::delete($model, 'platform.banners.list');
    }

    public function removeAll()
    {
        $ids = request()->input('select-all');
        $count = count($ids);

        foreach ($ids as $id) {
            $model = Banner::where('id', $id);
            parent::delete($model->first(), '', true);
        }

        Toast::info(
            "$count banners apagados"
        );

        return redirect()->route('platform.banners.list');
    }

    public static function routes()
    {
        parent::routeList('banners');
    }
    
    public static function permissions()
    {
        return parent::crudPermissions('banners');
    }
    
    protected static function permissionSlug() : string
    {
        return 'banners';
    }
}
