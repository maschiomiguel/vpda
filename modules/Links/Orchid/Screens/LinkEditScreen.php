<?php

declare(strict_types=1);

namespace Modules\Links\Orchid\Screens;

use Modules\Links\Models\Link;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Input;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Upload;
use App\Modules\ModulesScreen;

class LinkEditScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Link $model): iterable
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
        return $this->editScreenName($this->model, 'link');
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
            parent::getReturnLink('platform.links.list'),
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
                        ->help("Se marcado, esse link ficará visível ao acessar o site.")
                        ->checked($this->model->exists ? (bool)$this->model->active : true)
                        ->canSee($locale === 'pt-BR'),
                    
                    Input::make('model.name')
                        ->type('text')
                        ->title("Nome")
                        ->required()
                        ->maxlength(150)
                        ->canSee($locale === 'pt-BR'),
                        
                    Input::make("model.$locale.text_1")
                        ->type('text')
                        ->title('Texto do link')
                        ->placeholder('Texto do link')
                        ->value($this->model->translate($locale)?->text_1),
                    
                    Input::make("model.$locale.text_2")
                        ->type('text')
                        ->title('Link do footer')
                        ->placeholder('Link do footer')
                        ->value($this->model->translate($locale)?->text_2),
                    
                    Upload::make('model.attachment')
                        ->groups('image_link')
                        ->acceptedFiles("image/*")
                        ->resizeWidth(1280)
                        ->resizeHeight(1280)
                        ->set('data-upload-compress', "1")
                        ->maxFileSize(2)
                        ->multiple(false)
                        ->maxFileSize(1)
                        ->title("Ícone")
                        ->help('Ícone do link que aparecerá no footer. Tamanho recomendado: 32x32px.')
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

    public function save(Link $model, Request $request)
    {
        return parent::createOrUpdate($model, 'platform.links.list', [
            'model.name' => 'required',
        ]);
    }
    
    public function remove(Link $model)
    {
        return parent::delete($model, 'platform.links.list');
    }
    
    public function toogleField(Link $model)
    {
        return parent::toggleField($model);
    }

    public function sort()
    {
        return parent::sortModel(Link::class);
    }

    public static function routes()
    {
        parent::routeEdit('links', 'links');     
        parent::routeCreate('links', 'links');
    }
    
    protected static function permissionSlug() : string
    {
        return 'links';
    }
}
