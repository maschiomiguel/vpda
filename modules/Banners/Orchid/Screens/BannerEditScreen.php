<?php

declare(strict_types=1);

namespace Modules\Banners\Orchid\Screens;

use Modules\Banners\Models\Banner;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Input;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Upload;
use App\Modules\ModulesScreen;
use App\Orchid\Fields\Matrix;
use App\Orchid\Fields\TinyMCE;
use Orchid\Screen\Fields\TextArea;

class BannerEditScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Banner $model): iterable
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
        return $this->editScreenName($this->model, 'banner');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        $remove = request('duplicate') ? [] : [parent::getRemoveButton($this->model, $this->model->exists)];

        return [
            parent::getReturnLink('platform.banners.list'),
            ...$remove,
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

        foreach (languages()->languages() as $language) {
            $locale = $language->locale;

            $fields = [
                Layout::rows([
                    Input::make('duplicate')
                        ->type('hidden')
                        ->value(request('duplicate') ? '1' : '0')
                        ->canSee($locale === 'pt-BR'),

                    Switcher::make('model.active')
                        ->sendTrueOrFalse()
                        ->title("Ativo")
                        ->help("Se marcado, esse banner ficará visível ao acessar o site.")
                        ->checked($this->model->exists ? (bool)$this->model->active : true)
                        ->canSee($language->code == "pt"),

                    Input::make('model.name')
                        ->type('text')
                        ->title("Nome")
                        ->required()
                        ->maxlength(150)
                        ->popover('Esse nome não aparecerá no site, é apenas um controle interno.')
                        ->canSee($language->code == "pt"),

                    TextArea::make("model.$locale.text_1")
                        ->type('text')
                        ->title('Frase 1')
                        ->placeholder('Frase 1')
                        ->value($this->model->translate($locale)?->text_1),

                    TextArea::make("model.$locale.text_2")
                        ->type('text')
                        ->title('Frase 2')
                        ->placeholder('Frase 2')
                        ->value($this->model->translate($locale)?->text_2),

                    Input::make("model.$locale.link_1")
                        ->type('text')
                        ->title('Link 1')
                        ->placeholder('https://www.exemplo.com.br')
                        ->value($this->model->translate($locale)?->link_1)
                        ->help("Caso fique em branco, irá direcionar para o whatsapp"),

                    Input::make("model.$locale.text_3")
                        ->type('text')
                        ->title("Texto do botão")
                        ->placeholder("Exemplo: 'Fale conosco pelo WhatsApp'")
                        ->value($this->model->translate($locale)?->text_3)
                        ->help("Caso fique em branco, irá  exibir 'Solicite um orçamento'"),

                    Upload::make('model.attachment')
                        ->groups("desktop_banner_$locale")
                        ->maxFiles(1)
                        ->multiple(false)
                        ->title("Banner Desktop")
                        ->help(screens()->getImageHelp('default-16x9-lg'))
                        ->resizeWidth(1920)
                        ->resizeHeight(1280)
                        ->set('data-upload-compress', "1")
                        ->maxFileSize(2)
                        ->targetId(),

                    Upload::make('model.attachment')
                        ->groups("mobile_banner_$locale")
                        ->maxFiles(1)
                        ->multiple(false)
                        ->title("Banner Mobile")
                        ->help(screens()->getImageHelp('default-6x9-lg'))
                        ->resizeWidth(1280)
                        ->resizeHeight(1280)
                        ->set('data-upload-compress', "1")
                        ->maxFileSize(2)
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

    public function save(Banner $model, Request $request)
    {
        return parent::createOrUpdate($model, 'platform.banners.list', [
            'model.name' => 'required',
        ]);
    }

    public function remove(Banner $model)
    {
        return parent::delete($model, 'platform.banners.list');
    }

    public function toogleField(Banner $model)
    {
        return parent::toggleField($model);
    }

    public function sort()
    {
        return parent::sortModel(Banner::class);
    }

    public static function routes()
    {
        parent::routeEdit('banners');
        parent::routeCreate('banners');
    }

    protected static function permissionSlug(): string
    {
        return 'banners';
    }

    protected function preProcessData(array $data): array
    {
        if (empty($data['words'])) {
            $data['words'] = [];
        }

        return $data;
    }
}
