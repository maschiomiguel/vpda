<?php

declare(strict_types=1);

namespace Modules\Contact\Orchid\Screens\PagesContact;

use Modules\Contact\Models\PageContact;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Illuminate\Http\Request;
use App\Modules\ModulesScreen;
use Orchid\Screen\Fields\Upload;

class PageContactEditScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(PageContact $model): iterable
    {
        checkAuth('platform.pagescontact.edit');
        $this->model = $model->firstOrNew();

        return [
            'model' => $this->model,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->model->exists ? "Editando página de contato" : "Criando página de contato";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
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
                    Input::make("model.$locale.phones")->value("")->hidden(),
                    Matrix::make("model.$locale.phones")
                        ->columns([
                            'Telefone' => 'phone',
                            'Link do telefone (somente números, colocar código do país)' => 'phone_link',
                        ])
                        ->value($this->model->translate($locale)?->phones ?: [[]]),

                    Input::make("model.$locale.emails")->value("")->hidden(),
                    Matrix::make("model.$locale.emails")
                        ->columns([
                            'E-mail' => 'email',
                        ])
                        ->value($this->model->translate($locale)?->emails ?: [[]])
                        ->maxRows(1),

                    Input::make("model.$locale.whatsapps")->value("")->hidden(),
                    Matrix::make("model.$locale.whatsapps")
                        ->columns([
                            'Whatsapp' => 'phone',
                            'Link do whatsapp (somente números, colocar código do país)' => 'phone_link',
                        ])
                        ->value($this->model->translate($locale)?->whatsapps ?: [[]])
                        ->maxRows(1),

                    // Input::make("model.$locale.adresses")->value("")->hidden(),
                    // Matrix::make("model.$locale.adresses")
                    //     ->columns([
                    //         'Endereço' => 'address',
                    //         'Link do endereço' => 'link',
                    //     ])
                    //     ->value($this->model->translate($locale)?->adresses ?: [[]])
                    //     ->style('height:70px !important;')
                    //     ->maxRows(1)
                    //     ->removableRows(false),

                    Input::make("model.$locale.social_networks")->value("")->hidden(),
                    Matrix::make("model.$locale.social_networks")
                        ->columns([
                            'Facebook Link' => 'facebook',
                            'Facebook Username' => 'facebook_username',
                            'Twitter' => 'twitter',
                            'Twitter Username' => 'twitter_username',
                            'Instagram' => 'instagram',
                            'Instagram Username' => 'instagram_username',
                            'Linkedin' => 'linkedin',
                            'Linkedin Username' => 'linkedin_username',
                            'Youtube' => 'youtube',
                            'Youtube Username' => 'youtube_username',
                        ])
                        ->value($this->model->translate($locale)?->social_networks ?: [[]])
                        ->maxRows(1)
                        ->removableRows(false),

                    // Input::make("model.$locale.text_2")
                    //     ->type('text')
                    //     ->title("Texto CTA formulário")
                    //     ->value($this->model->translate($locale)?->text_2),

                    TextArea::make("model.$locale.keywords")
                        ->title('Palavras-chave (Google)')
                        ->placeholder('Palavras-chave (Google)')
                        ->value($this->model->translate($locale)?->keywords)
                        ->help(" Separe os valores usando vírgulas. Exemplo: nome do seu produto, nome do seu serviço")
                        ->popover('Palavras ou frases que descrevem seu produto ou serviço selecionadas para determinar quando e onde seu anúncio pode ser exibido. As palavras-chave que você escolhe são usadas para exibir seus anúncios para as pessoas.'),

                    TextArea::make("model.$locale.description")
                        ->title('Description (Google)')
                        ->placeholder('Description (Google)')
                        ->value($this->model->translate($locale)?->description)
                        ->help("Esse texto é exibido pelos resultados da pesquisa feita")
                        ->maxlength(160)
                        ->popover('Meta Description é o pequeno texto que aparece logo abaixo do título e do link de uma página quando se faz uma pesquisa no Google.'),
                ]),
            ];

            $language_fields[$language->name] = $fields;
        }

        $languages_panel = count($language_fields) > 1 ? Layout::tabs($language_fields) : array_values($language_fields)[0];

        return [
            $languages_panel,
        ];
    }

    public function save(PageContact $model, Request $request)
    {
        checkAuth('platform.pagescontact.edit');
        $model = $model->firstOrNew();
        return parent::createOrUpdate($model, 'platform.pagescontact.edit', []);
    }

    public static function routes()
    {
        parent::routeSingle('página de contato', 'pagescontact');
    }

    public static function permissions()
    {
        return parent::editPermission('página de contato', 'pagescontact');
    }
}
