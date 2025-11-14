<?php

declare(strict_types=1);

namespace Modules\Contact\Orchid\Screens\SiteEmails;

use Modules\Contact\Models\SiteEmail;
use Orchid\Support\Facades\Layout;
use App\Modules\ModulesScreen;
use Orchid\Screen\Sight;

class SiteEmailsViewScreen extends ModulesScreen
{
    protected $model;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(SiteEmail $model): iterable
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
        checkAuth('platform.siteemails.view');
        return 'Visualizando mensagem do site';
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
            parent::getReturnLink('platform.siteemails.list'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {

        $fields = [
            Sight::make('form_name', 'Formulário'),
            Sight::make('name', 'Nome'),
            Sight::make('email', 'E-mail'),
            Sight::make('phone', 'Telefone'),
            Sight::make('product', 'Solução Selecionada'),
            Sight::make('created_at', 'Data')->render(fn($e) => $e->created_at?->format('d/m/Y H:i')),
            Sight::make('message', 'Mensagem')->render(fn($e) => nl2br(e($e->message))),
        ];
        
        if($this->model->form_data){
            switch ($this->model->form_slug) {
                case 'jobs':
                    $field = 'Currículo';
                    break;
                case 'interest-product':
                    $field = 'Produto';
                    break;
                case 'interest-service':
                    $field = 'Serviço';
                    break;
                
                default:
                    $field = false;
                    break;
            }
            if($field){
                $link = Sight::make('form_data', $field)->render(fn($e) => '<a target="_blank" href='.$e->form_data.'> Clique para visualizar </a>');
                array_push($fields, $link);
            }
        }

        return [
            Layout::legend('model', 
                    $fields
                )->title('Mensagem')
        ];
    }

    public function remove(SiteEmail $model)
    {
        return parent::delete($model, 'platform.siteemails.list');
    }
    
    public static function routes()
    {
        parent::routeView('mensagem do site', 'siteemails');
    }
    
    protected static function permissionSlug() : string
    {
        return 'siteemails';
    }
}
