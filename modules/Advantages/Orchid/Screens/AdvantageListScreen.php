<?php

namespace Modules\Advantages\Orchid\Screens;

use Modules\Advantages\Models\Advantage;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\DropDown;
use App\Modules\ModulesScreen;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Support\Facades\Toast;

class AdvantageListScreen extends ModulesScreen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        checkAuth('platform.advantages.list');

        return [
            'lista' => Advantage::orderBy('order')
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
        return 'Lista de vantagens';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            parent::getCreateLink('platform.advantages.create'),
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
                TD::make()->sortable('advantages'),
                TD::make('checkbox', CheckBox::make('select-all')->class("form-check-input select-all-report-checks"))->checkbox('advantages'),
                TD::make("name", "Nome"),
                TD::make("active", "Ativo")->toggleActive('advantages'),
                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Advantage $model) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            parent::getEditButton($model, 'platform.advantages.edit', true),
                            parent::getRemoveButton($model, true),
                        ])),
            ]),
        ];
    }
    
    public function remove(Advantage $model)
    {
        return parent::delete($model, 'platform.advantages.list');
    }

    public function removeAll()
    {
        $ids = request()->input('select-all');
        $count = count($ids);

        foreach ($ids as $id) {
            $model = Advantage::where('id', $id);
            parent::delete($model->first(), '', true);
        }

        Toast::info(
            "$count vantagens apagadas"
        );

        return redirect()->route('platform.advantages.list');
    }

    public static function routes()
    {
        parent::routeList('vantagens', 'advantages');
    }
    
    public static function permissions()
    {
        return parent::crudPermissions('vantagens', 'advantages');
    }
    
    protected static function permissionSlug() : string
    {
        return 'advantages';
    }
}
