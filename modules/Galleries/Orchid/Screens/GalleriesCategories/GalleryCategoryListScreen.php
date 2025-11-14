<?php

namespace Modules\Galleries\Orchid\Screens\GalleriesCategories;

use Modules\Galleries\Models\GalleryCategory;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\DropDown;
use App\Modules\ModulesScreen;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Support\Facades\Toast;

class GalleryCategoryListScreen extends ModulesScreen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        checkAuth('platform.galleriescategories.list');

        return [
            'lista' => GalleryCategory::orderBy('order')
                ->withCount('galleries')
                ->filters()
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
        return 'Lista de categorias de posts';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            parent::getCreateLink('platform.galleriescategories.create'),
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
                TD::make()->sortable('galleriescategories'),
                TD::make('checkbox', CheckBox::make('select-all')->class("form-check-input select-all-report-checks"))->checkbox('galleriescategories'),
                TD::make("name", "Nome"),
                TD::make("galleries_count", "Galerias")->width('1%')->align(TD::ALIGN_CENTER),
                TD::make("active", "Ativo")->toggleActive('galleriescategories'),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (GalleryCategory $model) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            parent::getEditButton($model, 'platform.galleriescategories.edit', true),
                            parent::getRemoveButton($model, true),
                        ])),
            ]),
        ];
    }
    
    public function remove(GalleryCategory $model)
    {
        return parent::delete($model, 'platform.galleriescategories.list');
    }

    public function removeAll()
    {
        $ids = request()->input('select-all');
        $count = count($ids);

        foreach ($ids as $id) {
            $model = GalleryCategory::where('id', $id);
            parent::delete($model->first(), '', true);
        }

        Toast::info(
            "$count categorias de posts apagadas"
        );

        return redirect()->route('platform.galleriescategories.list');
    }

    public static function routes()
    {
        parent::routeList('categorias de posts', 'galleriescategories');
    }
    
    public static function permissions()
    {
        return parent::crudPermissions('categorias de posts', 'galleriescategories');
    }
    
    protected static function permissionSlug() : string
    {
        return 'galleriescategories';
    }
}
