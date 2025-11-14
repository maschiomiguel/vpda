<?php

declare(strict_types=1);

namespace Modules\Differentials\Orchid\Screens;

use Modules\Differentials\Models\Differential;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\Input;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Upload;
use App\Modules\ModulesScreen;
use App\Orchid\Fields\Matrix;
use Orchid\Screen\Fields\TextArea;

class DifferentialEditScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Differential $model): iterable
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
        return $this->editScreenName($this->model, 'diferencial');
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
            parent::getReturnLink('platform.differentials.list'),
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
                        ->help("Se marcado, esse diferencial ficará visível ao acessar o site.")
                        ->checked($this->model->exists ? (bool)$this->model->active : true)
                        ->canSee($locale === 'pt-BR'),
                    
                    Input::make('model.name')
                        ->type('text')
                        ->title("Nome")
                        ->required()
                        ->maxlength(150)
                        ->canSee($locale === 'pt-BR'),
                        
                    Input::make("model.$locale.text_1")
                        ->title('Frase 1')
                        ->placeholder('Frase 1')
                        ->value($this->model->translate($locale)?->text_1),
                    
                    TextArea::make("model.$locale.text_2")
                        ->title('Frase 2')
                        ->placeholder('Frase 2')
                        ->value($this->model->translate($locale)?->text_2),

                    // Input::make("model.$locale.text_3")->value("")->hidden(),
                    // Matrix::make("model.$locale.text_3")
                    //     ->title('Cores')
                    //     ->columns([
                    //         'Cor' => 'color',
                    //         'Nome da cor' => 'color_name'
                    //     ])->fields([
                    //         'color' => Input::make('color')
                    //             ->type('color')
                    //             ->placeholder('Selecione uma cor'),
                    //         'color_name' => Input::make('color_name')
                    //             ->type('text')
                    //             ->placeholder('Digite o nome da cor'),
                    //     ])
                    //     ->value($this->model->translate($locale)?->text_3)
                    //     ->canSee($locale === 'pt-BR'),
                    
                    Upload::make('model.attachment')
                        ->groups('image_differential')
                        ->acceptedFiles("image/*")
                        ->maxFiles(1)
                        ->multiple(false)
                        ->maxFileSize(2)
                        ->title("Imagem")
                        ->help(screens()->getImageHelp('differential'))
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

    public function save(Differential $model, Request $request)
    {
        return parent::createOrUpdate($model, 'platform.differentials.list', [
            'model.name' => 'required',
        ]);
    }
    
    public function remove(Differential $model)
    {
        return parent::delete($model, 'platform.differentials.list');
    }
    
    public function toogleField(Differential $model)
    {
        return parent::toggleField($model);
    }

    public function sort()
    {
        return parent::sortModel(Differential::class);
    }

    public static function routes()
    {
        parent::routeEdit('diferenciais', 'differentials');     
        parent::routeCreate('diferenciais', 'differentials');
    }
    
    protected static function permissionSlug() : string
    {
        return 'differentials';
    }
}
