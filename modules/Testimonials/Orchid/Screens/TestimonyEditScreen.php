<?php

declare(strict_types=1);

namespace Modules\Testimonials\Orchid\Screens;

use Modules\Testimonials\Models\Testimony;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Input;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Upload;
use App\Modules\ModulesScreen;
use Orchid\Screen\Fields\TextArea;

class TestimonyEditScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Testimony $model): iterable
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
        return $this->editScreenName($this->model, 'depoimento');
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
            parent::getReturnLink('platform.testimonials.list'),
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
                        ->help("Se marcado, esse depoimento ficará visível ao acessar o site.")
                        ->checked($this->model->exists ? (bool)$this->model->active : true)
                        ->canSee($language->code == 'pt'),

                    Input::make('model.name')
                        ->type('text')
                        ->title("Nome")
                        ->required()
                        ->maxlength(150)
                        ->canSee($language->code == 'pt')
                        ->popover('Esse nome não aparecerá no site, é apenas um controle interno.'),



                    /*
                    Select::make('model.note')
                        ->type('text')
                        ->title("Nota")
                        ->canSee($language->code == 'pt')
                        ->options([
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                        ])
                        ->empty('Sem nota', '0'),
                    */

                    Input::make("model.$locale.text_1")
                        ->type('text')
                        ->title('Nome')
                        ->placeholder('Nome')
                        ->value($this->model->translate($locale)?->text_1),

                    Input::make("model.$locale.text_2")
                        ->type('text')
                        ->title('Cargo')
                        ->placeholder('Cargo')
                        ->value($this->model->translate($locale)?->text_2),

                    TextArea::make("model.$locale.text_3")
                        ->type('text')
                        ->title('Depoimento')
                        ->placeholder('Depoimento')
                        ->value($this->model->translate($locale)?->text_3)
                        ->rows(7),

                    // Input::make("model.$locale.link_1")
                    // ->type('text')
                    // ->title('Link do vídeo')
                    // ->placeholder('Link do vídeo')
                    // ->value($this->model->translate($locale)?->link_1),

                    // Upload::make('model.attachment')
                    //     ->groups('image_testimony')
                    //     ->acceptedFiles("image/*")
                    //     ->maxFiles(1)
                    //     ->multiple(false)
                    //     ->resizeWidth(1280)
                    //     ->resizeHeight(1280)
                    //     ->set('data-upload-compress', "1")
                    //     ->maxFileSize(2)
                    //     ->title("Imagem")
                    //     ->help(screens()->getImageHelp('default-1x1-sm'))
                    //     ->canSee($locale === 'pt-BR')
                    //     ->targetId(),
                ]),
            ];

            $language_fields[$language->name] = $fields;
        }

        $languages_panel = count($language_fields) > 1 ? Layout::tabs($language_fields) : array_values($language_fields)[0];

        return [
            $languages_panel,
        ];
    }

    public function save(Testimony $model, Request $request)
    {
        return parent::createOrUpdate($model, 'platform.testimonials.list', [
            'model.name' => 'required',
        ]);
    }

    public function remove(Testimony $model)
    {
        return parent::delete($model, 'platform.testimonials.list');
    }

    public function toogleField(Testimony $model)
    {
        return parent::toggleField($model);
    }

    public function sort()
    {
        return parent::sortModel(Testimony::class);
    }

    public static function routes()
    {
        parent::routeEdit('depoimentos', 'testimonials');
        parent::routeCreate('depoimentos', 'testimonials');
    }

    protected static function permissionSlug(): string
    {
        return 'testimonials';
    }
}
