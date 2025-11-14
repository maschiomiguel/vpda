<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Configuration;

use App\Models\Configuration;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Upload;
use App\Modules\ModulesScreen;
use Illuminate\Support\Facades\Auth;

class ConfigurationEditScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Configuration $model): iterable
    {
        checkAuth('platform.configurations.edit');
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
        return $this->model->exists ? "Editando configurações do site" : "Criando configurações do site";
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
        $email_panel = Layout::rows([
            Switcher::make('model.email_authenticated')
                ->sendTrueOrFalse()
                ->title("E-mail autenticado")
                ->help("Se marcado, os dados preenchidos no DSN serão usados para enviar e-mails do site."),

            Input::make('model.email_from')
                ->type('text')
                ->title("Email 'from'")
                ->help('Esse e-mail é usado como remetente dos e-mails do site quando o envio autenticado está desabilitado.'),

            Input::make('model.email_dsn')
                ->type('text')
                ->title("DSN de e-mail")
                ->help('Formato: smtp://my@gmail.com:secret@smtp.gmail.com:587?tls=true'),
        ])->canSee(Auth::id() == 1);

        $language_fields = [];

        foreach (languages()->languages() as $language) {
            $locale = $language->locale;

            $fields = [
                Layout::rows([
                    /*TinyMCE::make("model.$locale.text")
                        ->title("Texto")
                        ->value($this->model->translate($locale)?->text),*/]),
            ];

            $language_fields[$language->name] = $fields;
        }

        $languages_panel = count($language_fields) > 1 ? Layout::tabs($language_fields) : array_values($language_fields)[0];

        $seo_fields = [];

        foreach (languages()->languages() as $language) {
            $locale = $language->locale;

            $fields = [
                Layout::rows([

                    Upload::make('model.attachment')
                        ->groups("image_logo")
                        ->multiple(false)
                        ->title("Logo do cabeçalho")
                        ->set('data-upload-compress', "1")
                        ->maxFileSize(2)
                        ->targetId(),

                    Upload::make('model.attachment')
                        ->groups("image_logo_footer")
                        ->multiple(false)
                        ->title("Logo do rodapé")
                        ->set('data-upload-compress', "1")
                        ->maxFileSize(2)
                        ->targetId(),

                    // Input::make("model.primary_color")
                    //     ->title('Cor primária do site')
                    //     ->type('color')
                    //     ->value($this->model->primary_color),

                    // Input::make("model.hover_color")
                    //     ->title('Cor do hover do site')
                    //     ->type('color')
                    //     ->value($this->model->hover_color),

                    // Input::make("model.whatsapp_button_color")
                    //     ->title('Cor dos botões do WhatsApp (CTAs)')
                    //     ->type('color')
                    //     ->value($this->model->whatsapp_button_color),

                ]),
                Layout::rows([
                    TextArea::make("model.$locale.custom_js_head")
                        ->title('Código javascript na tag <head>')
                        ->rows(5)
                        ->class('form-control mw-100')
                        ->value($this->model->translate($locale)?->custom_js_head)
                        ->help(e("Esse código será adicionado no início da tag <HEAD>. Insira código JavaScript com as tags <script> e </script>.")),

                    TextArea::make("model.$locale.custom_js_body")
                        ->title('Código javascript na tag <body>')
                        ->rows(5)
                        ->class('form-control mw-100')
                        ->value($this->model->translate($locale)?->custom_js_body)
                        ->help(e("Esse código será adicionado no início da tag <BODY>. Insira código JavaScript com as tags <script> e </script> | <noscript> e </noscript>.")),

                    /*TextArea::make("model.$locale.keywords")
                        ->title('Palavras-chave (Google)')
                        ->placeholder('Palavras-chave (Google)')
                        ->value($this->model->translate($locale)?->keywords)
                        ->help(" Separe os valores usando vírgulas. Exemplo: nome do seu produto, nome do seu serviço"),*/

                    /*TextArea::make("model.$locale.description")
                        ->title('Description (Google)')
                        ->placeholder('Description (Google)')
                        ->value($this->model->translate($locale)?->description)
                        ->help("Esse texto é exibido pelos resultados da pesquisa feita")
                        ->maxlength(160),*/
                ]),
            ];

            $seo_fields['SEO ' . $language->name] = $fields;
        }

        $seo_panel = count($seo_fields) > 1 ? Layout::tabs($seo_fields) : array_values($seo_fields)[0];

        $upload_panel = Layout::rows([
            Upload::make('model.attachment')
                ->groups('image_page_configuration')
                ->acceptedFiles("image/*")
                ->maxFiles(10)
                ->multiple(true)
                ->resizeWidth(1280)
                ->resizeHeight(1280)
                ->set('data-upload-compress', "1")
                ->maxFileSize(2)
                ->title("Imagens")
                ->help("Proporção recomendada: 16x9 | Largura máxima recomendada: 1920px | Peso máximo: 200kb")
                ->targetId(),
        ]);

        return [
            $email_panel,
            // $languages_panel,
            $seo_panel,
            // $upload_panel,
        ];
    }

    public function save(Configuration $model, Request $request)
    {
        checkAuth('platform.configurations.edit');
        $model = $model->firstOrNew();
        return parent::createOrUpdate($model, 'platform.configurations.edit', []);
    }

    public static function routes()
    {
        parent::routeSingle('configurações', 'configurations');
    }

    public static function permissions()
    {
        return parent::editPermission('configurações', 'configurations');
    }
}
