<?php

declare(strict_types=1);

namespace Modules\Galleries\Orchid\Screens\PagesGalleries;

use Modules\Galleries\Models\PageGallery;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\TextArea;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Upload;
use App\Modules\ModulesScreen;
use App\Orchid\Fields\TinyMCE;

class PageGalleryEditScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(PageGallery $model): iterable
    {
        checkAuth('platform.pagesgalleries.edit');
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
        return $this->model->exists ? "Editando página de galeria" : "Criando página de galeria";
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
        $seo_fields = [];

        foreach (languages()->languages() as $language) {
            $locale = $language->locale;
            
            $fields = [
                Layout::rows([
                    TinyMCE::make("model.$locale.text")
                        ->title("Texto")
                        ->value($this->model->translate($locale)?->text),
                    
                    Upload::make('model.attachment')
                        ->groups('image_page_gallery')
                        ->acceptedFiles("image/*")
                        ->maxFiles(10)
                        ->multiple(true)
                        ->resizeWidth(1280)
                        ->resizeHeight(1280)
                        ->set('data-upload-compress', "1")
                        ->maxFileSize(2)
                        ->title("Imagens")
                        ->help(screens()->getImageHelp('galleries'))
                        ->targetId()
                        ->canSee($locale === 'pt-BR'),
                        
                    TextArea::make("model.$locale.keywords")
                        ->title('Palavras-chave (Google)')
                        ->placeholder('Palavras-chave (Google)')
                        ->value($this->model->translate($locale)?->keywords)
                        ->help(" Separe os valores usando vírgulas. Exemplo: nome do seu serviço, nome do seu galeria")
                        ->popover('Palavras ou frases que descrevem seu galeria ou galeria selecionadas para determinar quando e onde seu anúncio pode ser exibido. As palavras-chave que você escolhe são usadas para exibir seus anúncios para as pessoas.'),

                    TextArea::make("model.$locale.description")
                        ->title('Description (Google)')
                        ->placeholder('Description (Google)')
                        ->value($this->model->translate($locale)?->description)
                        ->help("Esse texto é exibido pelos resultados da pesquisa feita")
                        ->maxlength(160)
                        ->popover('Meta Description é o pequeno texto que aparece logo abaixo do título e do link de uma página quando se faz uma pesquisa no Google.'),
                ]),
            ];

            $seo_fields[$language->name] = $fields;
        }

        $seo_panel = count($seo_fields) > 1 ? Layout::tabs($seo_fields) : array_values($seo_fields)[0];
        
        return [
            $seo_panel,
        ];
    }

    public function save(PageGallery $model, Request $request)
    {
        checkAuth('platform.pagesgalleries.edit');
        $model = $model->firstOrNew();
        return parent::createOrUpdate($model, 'platform.pagesgalleries.edit', [
            
        ]);
    }

    public static function routes()
    {
        parent::routeSingle('página de posts', 'pagesgalleries');
    }
    
    public static function permissions()
    {
        return parent::editPermission('página de posts', 'pagesgalleries');
    }
}
