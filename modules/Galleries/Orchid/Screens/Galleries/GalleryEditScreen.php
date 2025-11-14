<?php

declare(strict_types=1);

namespace Modules\Galleries\Orchid\Screens\Galleries;

use Modules\Galleries\Models\Gallery;
use Modules\Galleries\Models\GalleryCategory;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Input;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Upload;
use App\Modules\ModulesScreen;
use App\Orchid\Fields\TinyMCE;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;

class GalleryEditScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Gallery $model): iterable
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
        return $this->editScreenName($this->model, 'post');
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
            parent::getReturnLink('platform.galleries.list'),
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
                        ->help("Se marcado, esse post ficará visível ao acessar o site.")
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
                        ->groups('image_gallery')
                        ->acceptedFiles("image/*")
                        ->multiple(false)
                        ->resizeWidth(1280)
                        ->resizeHeight(1280)
                        ->set('data-upload-compress', "1")
                        ->maxFileSize(2)
                        ->title("Imagens")
                        ->help('Proporção recomendada: 4:5. Tamanho máximo: 2MB')
                        ->targetId()
                        ->canSee($locale === 'pt-BR'),
                        
                    // TextArea::make("model.$locale.keywords")
                    //     ->title('Palavras-chave (Google)')
                    //     ->placeholder('Palavras-chave (Google)')
                    //     ->value($this->model->translate($locale)?->keywords)
                    //     ->help(" Separe os valores usando vírgulas. Exemplo: nome do seu serviço, nome do seu galeria")
                    //     ->popover('Palavras ou frases que descrevem seu galeria ou galeria selecionadas para determinar quando e onde seu anúncio pode ser exibido. As palavras-chave que você escolhe são usadas para exibir seus anúncios para as pessoas.'),

                    // TextArea::make("model.$locale.description")
                    //     ->title('Description (Google)')
                    //     ->placeholder('Description (Google)')
                    //     ->value($this->model->translate($locale)?->description)
                    //     ->help("Esse texto é exibido pelos resultados da pesquisa feita")
                    //     ->maxlength(160)
                    //     ->popover('Meta Description é o pequeno texto que aparece logo abaixo do título e do link de uma página quando se faz uma pesquisa no Google.'),
                ]),
            ];

            $language_fields[$language->name] = $fields;
        }

        $languages_panel = count($language_fields) > 1 ? Layout::tabs($language_fields) : array_values($language_fields)[0];

        return [
            $languages_panel,
        ];
    }

    public function save(Gallery $model, Request $request)
    {
        return parent::createOrUpdate($model, 'platform.galleries.list', [
            'model.name' => 'required',
        ]);
    }
    
    public function remove(Gallery $model)
    {
        return parent::delete($model, 'platform.galleries.list');
    }
    
    public function toogleField(Gallery $model)
    {
        return parent::toggleField($model);
    }

    public function sort()
    {
        return parent::sortModel(Gallery::class);
    }

    public static function routes()
    {
        parent::routeEdit('posts', 'galleries');     
        parent::routeCreate('posts', 'galleries');
    }
    
    protected function shouldTransferNameToTitle() : bool
    {
        return true;
    }
    
    protected static function permissionSlug() : string
    {
        return 'galleries';
    }
}
