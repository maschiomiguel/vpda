<?php

declare(strict_types=1);

namespace Modules\PagePrivacy\Orchid\Screens;

use Modules\PagePrivacy\Models\PagePrivacy;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Illuminate\Http\Request;
use App\Modules\ModulesScreen;
use App\Orchid\Fields\TinyMCE;
use Orchid\Screen\Fields\Switcher;

class PagePrivacyEditScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(PagePrivacy $model): iterable
    {
        checkAuth('platform.pagesprivacy.edit');
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
        return $this->model->exists ? "Editando política de privacidade" : "Criando política de privacidade";
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
                    
                    TinyMCE::make("model.$locale.text")
                        ->title("Texto")
                        ->value($this->model->translate($locale)?->text)
                        ->help("
                        Para atualizar os dados da empresa automáticamente copiar as variáveis abaixo:<br>
                        {{nome}} - Vai imprimir o nome da empresa.<br>
                        {{razao_social}} - Vai imprimir a razão social da empresa.<br>
                        {{cnpj}} - Vai imprimir o cnpj da empresa.<br>
                        {{email}} - Vai imprimir o email da empresa cadastrado.<br>
                        {{telefone}} - Vai imprimir o primeiro telefone cadastrado.<br>
                        "),

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

    public function save(PagePrivacy $model, Request $request)
    {
        checkAuth('platform.pagesprivacy.edit');
        $model = $model->firstOrNew();
        return parent::createOrUpdate($model, 'platform.pagesprivacy.edit', [
            
        ]);
    }

    public static function routes()
    {
        parent::routeSingle('política de privacidade', 'pagesprivacy');
    }
    
    public static function permissions()
    {
        return parent::editPermission('política de privacidade', 'pagesprivacy');
    }
}
