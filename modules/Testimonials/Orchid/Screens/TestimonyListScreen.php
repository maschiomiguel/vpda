<?php

namespace Modules\Testimonials\Orchid\Screens;

use Modules\Testimonials\Models\Testimony;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\DropDown;
use App\Modules\ModulesScreen;

class TestimonyListScreen extends ModulesScreen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        checkAuth('platform.testimonials.list');

        return [
            'lista' => Testimony::orderBy('order')
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
        return 'Lista de depoimentos';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            parent::getCreateLink('platform.testimonials.create'),
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
                TD::make()->sortable('testimonials'),
                TD::make("name", "Nome"),
                TD::make("active", "Ativo")->toggleActive('testimonials'),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Testimony $model) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            parent::getEditButton($model, 'platform.testimonials.edit', true),
                            parent::getRemoveButton($model, true),
                        ])),
            ]),
        ];
    }
    
    public function remove(Testimony $model)
    {
        return parent::delete($model, 'platform.testimonials.list');
    }

    public static function routes()
    {
        parent::routeList('depoimentos', 'testimonials');
    }
    
    public static function permissions()
    {
        return parent::crudPermissions('depoimentos', 'testimonials');
    }
    
    protected static function permissionSlug() : string
    {
        return 'testimonials';
    }
}
