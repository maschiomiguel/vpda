<?php

declare(strict_types=1);

namespace Modules\Advantages\Orchid\Screens;

use Modules\Advantages\Models\Advantage;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Input;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Upload;
use App\Modules\ModulesScreen;

class AdvantageEditScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Advantage $model): iterable
    {
        $this->model = $model;

        return [
            'model' => $model,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->editScreenName($this->model, 'vantagem');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            parent::getRemoveButton($this->model, $this->model->exists),
            parent::getReturnLink('platform.advantages.list'),
            parent::getSaveButton($this->model, true),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $language_fields = [];

        foreach (languages()->languages() as $language) {
            $locale = $language->locale;

            $fields = [
                Layout::rows([
                    Switcher::make('model.active')
                        ->sendTrueOrFalse()
                        ->title("Ativo")
                        ->help("Se marcado, essa vantagem ficará visível ao acessar o site.")
                        ->canSee($language->code == 'pt')
                        ->checked($this->model->exists ? (bool)$this->model->active : true),

                    Input::make('model.name')
                        ->type('text')
                        ->title("Nome")
                        ->required()
                        ->maxlength(150)
                        ->canSee($language->code == 'pt'),

                    Input::make("model.$locale.text_1")
                        ->type('text')
                        ->title('Texto')
                        ->placeholder('Texto')
                        ->value($this->model->translate($locale)?->text_1),

                    Upload::make('model.attachment')
                        ->groups('image_advantage')
                        ->acceptedFiles("image/*")
                        ->resizeWidth(1280)
                        ->resizeHeight(1280)
                        ->set('data-upload-compress', "1")
                        ->maxFileSize(2)
                        ->multiple(false)
                        ->maxFileSize(1)
                        ->title("Imagem")
                        ->help(screens()->getImageHelp('advantage'))
                        ->canSee($language->code == 'pt')
                        ->targetId(),
                ]),
            ];

            $language_fields[$language->name] = $fields;
        }

        $languages_panel = count($language_fields) > 1 ? Layout::tabs($language_fields) : array_values($language_fields)[0];

        return [
            $languages_panel,
        ];
    }

    protected function shouldTransferNameToTitle(): bool
    {
        return false;
    }

    public function save(Advantage $model, Request $request)
    {
        return parent::createOrUpdate($model, 'platform.advantages.list', [
            'model.name' => 'required',
        ]);
    }

    public function remove(Advantage $model)
    {
        return parent::delete($model, 'platform.advantages.list');
    }

    public function toogleField(Advantage $model)
    {
        return parent::toggleField($model);
    }

    public function sort()
    {
        return parent::sortModel(Advantage::class);
    }

    public static function routes()
    {
        parent::routeEdit('vantagens', 'advantages');
        parent::routeCreate('vantagens', 'advantages');
    }

    protected static function permissionSlug(): string
    {
        return 'advantages';
    }
}
