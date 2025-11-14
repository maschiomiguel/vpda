<?php

declare(strict_types=1);

namespace Modules\Videos\Orchid\Screens\Videos;

use Modules\Videos\Models\Video;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Input;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Upload;
use App\Modules\ModulesScreen;
use App\Orchid\Fields\TinyMCE;
use Orchid\Screen\Fields\TextArea;

class VideoEditScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Video $model): iterable
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
        return $this->editScreenName($this->model, 'video');
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
            parent::getReturnLink('platform.videos.list'),
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
                        ->help("Se marcado, esse video ficará visível ao acessar o site.")
                        ->checked($this->model->exists ? (bool)$this->model->active : true)
                        ->canSee($locale === 'pt-BR'),

                    Input::make('model.name')
                        ->type('text')
                        ->title("Nome")
                        ->required()
                        ->maxlength(150)
                        ->canSee($locale === 'pt-BR'),

                    Input::make("model.$locale.title")
                        ->type('text')
                        ->title('Nome')
                        ->placeholder('Nome')
                        ->value($this->model->translate($locale)?->title)
                        ->canSee($locale !== 'pt-BR'),

                    Input::make("model.$locale.short_text")
                        ->type('text')
                        ->title('Curtidas')
                        ->placeholder('Curtidas')
                        ->value($this->model->translate($locale)?->short_text),

                    Input::make("model.$locale.text")
                        ->type('text')
                        ->title('Comentários')
                        ->placeholder('Comentários')
                        ->value($this->model->translate($locale)?->text),

                    Upload::make('model.attachment')
                        ->groups('image_video')
                        ->multiple(false)
                        ->set('data-upload-compress', "1")
                        ->title("Imagens")
                        ->help('Proporção recomendada: 4:5. Tamanho máximo: 2MB')
                        ->targetId()
                        ->canSee($locale === 'pt-BR'),
                ]),
            ];

            $language_fields[$language->name] = $fields;
        }

        $languages_panel = count($language_fields) > 1 ? Layout::tabs($language_fields) : array_values($language_fields)[0];

        return [
            $languages_panel,
        ];
    }

    public function save(Video $model, Request $request)
    {
        return parent::createOrUpdate($model, 'platform.videos.list', [
            'model.name' => 'required',
        ]);
    }

    public function remove(Video $model)
    {
        return parent::delete($model, 'platform.videos.list');
    }

    public function toogleField(Video $model)
    {
        return parent::toggleField($model);
    }

    public function sort()
    {
        return parent::sortModel(Video::class);
    }

    public static function routes()
    {
        parent::routeEdit('videos', 'videos');
        parent::routeCreate('videos', 'videos');
    }

    protected function shouldTransferNameToTitle(): bool
    {
        return true;
    }

    protected static function permissionSlug(): string
    {
        return 'videos';
    }
}
