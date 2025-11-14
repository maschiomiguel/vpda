<?php

namespace App\Modules;

use Illuminate\Support\Facades\Route;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;
use Orchid\Platform\ItemPermission;
use Orchid\Support\Color;
use Tabuna\Breadcrumbs\Trail;

abstract class ModulesScreen extends Screen
{
    /**
     * URL da lista de elementos da restrita.
     * Exemplo: platform.posts.list'
     */
    protected $url_list = '';

    /**
     * Função que executa antes de fazer o fill salvar
     * Pode ser usada para alterar campos antes de salvar
     */
    protected function preProcessData(array $data): array
    {
        return $data;
    }

    protected function shouldTransferNameToTitle(): bool
    {
        return false;
    }

    protected function createOrUpdate(ModulesModel $model, string $route, array $validation = [])
    {
        if (request()->input('duplicate')) {
            $model->id = null;
            $model->exists = false;
        }

        $is_new = empty($model->id);

        $permissionSlug = static::permissionSlug();
        if ($permissionSlug) {
            if ($is_new) {
                checkAuth("platform.$permissionSlug.create");
            }
            else {
                checkAuth("platform.$permissionSlug.edit");
            }
        }

        request()->validate($validation);

        // $model->fill($request->collect('model')->toArray());
        // $model->save();

        $data = request()->collect('model')->toArray();

        // se está duplicando, cria um novo attachment para cada attachment que 
        // a entidade já tinha
        if (request()->input('duplicate')) {
            $new_ids = [];
            if (isset($data['attachment'])) {
                foreach ($data['attachment'] as $attachment_id) {
                    $attachment = Attachment::whereId($attachment_id)->first();

                    $attachment->id = null;
                    $attachment->exists = false;

                    $attachment->save();

                    $new_ids[] = $attachment->id;
                }

                $data['attachment'] = $new_ids;
            }
        }

        if ($this->shouldTransferNameToTitle()) {
            foreach (languages()->languages() as $language) {
                $data_array = &$data[$language->locale];

                if (empty($data_array['title'])) {
                    $data_array['title'] = $data['name'];
                }
            }
        }

        $data = $this->preProcessData($data);

        $model->checkAndSave($data);

        logsRestrita()->insertLog(
            sprintf(
                "%s %s %s %s",
                $is_new ? 'Cadastrou' : 'Editou',
                $model->getArticle(),
                $model->getEntityNameSingular(),
                $model->getLogName(),
            ),
            $is_new ? "create" : "edit",
            $model::class,
            $model->id,
        );

        Toast::info(sprintf(
            "%s salv%s com sucesso.",
            ucfirst($model->getEntityNameSingular()),
            $model->getArticle(),
        ));

        return redirect()->route($route);
    }

    protected function delete(ModulesModel $model, string $rota, $all = false)
    {
        $permissionSlug = static::permissionSlug();
        if ($permissionSlug) {
            checkAuth("platform.$permissionSlug.delete");
        }

        // $model->delete();
        $model->unlinkAndDelete();

        logsRestrita()->insertLog(
            sprintf("Deletou %s %s %s", $model->getArticle(), $model->getEntityNameSingular(), $model->getLogName()),
            "delete",
            $model::class,
            $model->id,
        );

        if ($all) {
            return true;
        } else {
            Toast::info(
                sprintf(
                    '%s deletad%s com sucesso',
                    ucfirst($model->getEntityNameSingular()),
                    $model->getArticle(),
                )
            );

            return redirect()->route($rota);
        }
    }


    public static function getEditButton(ModulesModel $model, string $link, bool $canSee)
    {
        $permissionSlug = static::permissionSlug();
        if ($permissionSlug) {
            if (!hasAuth("platform.$permissionSlug.edit")) {
                $canSee = false;
            }
        }

        return Link::make(__('Edit'))
            ->route($link, $model->id)
            ->icon('pencil')
            ->canSee($canSee);
    }

    public static function getViewButton(ModulesModel $model, string $link, bool $canSee)
    {
        $permissionSlug = static::permissionSlug();
        if ($permissionSlug) {
            if (!hasAuth("platform.$permissionSlug.view")) {
                $canSee = false;
            }
        }

        return Link::make(__('Visualizar'))
            ->route($link, $model->id)
            ->icon('eye')
            ->canSee($canSee);
    }

    public static function getRemoveButton(ModulesModel $model, bool $canSee)
    {
        $permissionSlug = static::permissionSlug();
        if ($permissionSlug) {
            if (!hasAuth("platform.$permissionSlug.delete")) {
                $canSee = false;
            }
        }

        return
            Button::make('Remover')
            ->method('remove')
            ->icon('trash')
            ->canSee($canSee)
            ->novalidate(true)
            ->confirm("Ao remover esse registro, todas informações relacionadas à ele serão deletadas e não poderão ser recuperadas. Deseja continuar?")
            ->class('btn btn-default text-danger')
            ->method('remove', [
                'id' => $model->id,
            ]);
    }

    public static function getDuplicateteButton(ModulesModel $model, string $link, bool $canSee)
    {
        $permissionSlug = static::permissionSlug();
        if ($permissionSlug) {
            if (!hasAuth("platform.$permissionSlug.create")) {
                $canSee = false;
            }
        }

        return Link::make('Duplicar')
            ->route($link, ['model' => $model->id, 'duplicate' => 1])
            ->icon('note')
            ->class('btn btn-default text-success')
            ->canSee($canSee);
    }

    public static function getRemoveSelectedButton($canSee = true)
    {
        $permissionSlug = static::permissionSlug();
        if ($permissionSlug) {
            if (!hasAuth("platform.$permissionSlug.delete")) {
                $canSee = false;
            }
        }

        return
            Button::make('Remover Selecionados')
            ->icon('trash')
            ->novalidate(true)
            ->confirm("Ao remover esses registros, todas informações relacionadas à eles serão deletadas e não poderão ser recuperadas. Deseja continuar?")
            ->class('btn btn-default text-danger remove-selected')
            ->method('removeAll')
            ->canSee($canSee);
    }

    public static function getSaveButton(ModulesModel $model, bool $canSee)
    {
        return
            Button::make('Salvar')
            ->method('save')
            ->id('save-button')
            ->type(Color::SUCCESS())
            ->icon('save')
            ->canSee($canSee);
    }

    public static function getCreateLink(string $route, bool $canSee = true)
    {
        $permissionSlug = static::permissionSlug();
        if ($permissionSlug) {
            if (!hasAuth("platform.$permissionSlug.create")) {
                $canSee = false;
            }
        }

        return
            Link::make('Adicionar')
            ->type(Color::SUCCESS())
            ->canSee(true)
            ->icon('plus')
            ->route($route)
            ->canSee($canSee);
    }

    public static function getReturnLink(string $route)
    {
        return
            Link::make('Voltar')
            ->icon('action-undo')
            ->route($route)
            ->class('btn btn-default');
    }

    public static function getExportLink(string $route)
    {
        return
            Button::make('Exportar')
            ->type(Color::INFO())
            ->icon('cloud-download')
            ->method('exportData')
            // ->parameters(request()->query())
            ->rawClick()
            ->novalidate()
            ->route($route);
    }

    public static function getImportLink(string $route, bool $canSee = true)
    {
        return Link::make(__('Importar'))
            ->route($route)
            ->icon('cloud-upload')
            ->canSee($canSee)
            ->type(Color::WARNING());
    }

    protected static function crudPermissions(string $name, ?string $slug = null)
    {
        if (!$slug) {
            $slug = $name;
        }

        return ItemPermission::group(ucfirst($name))
            ->addPermission("platform.$slug.list", "Listar $name")
            ->addPermission("platform.$slug.create", "Cadastrar $name")
            ->addPermission("platform.$slug.edit", "Editar $name")
            ->addPermission("platform.$slug.delete", "Deletar $name");
    }

    protected static function editPermission(string $name, ?string $slug = null)
    {
        if (!$slug) {
            $slug = $name;
        }

        return ItemPermission::group(ucfirst($name))
            ->addPermission("platform.$slug.edit", "Editar $name");
    }

    protected static function listViewDeletePermission(string $name, ?string $slug = null)
    {
        if (!$slug) {
            $slug = $name;
        }

        return ItemPermission::group(ucfirst($name))
            ->addPermission("platform.$slug.list", "Listar $name")
            ->addPermission("platform.$slug.view", "Visualizar $name")
            ->addPermission("platform.$slug.delete", "Deletar $name");
    }

    protected static function routeList(string $name, ?string $slug = null)
    {
        if (!$slug) {
            $slug = $name;
        }

        Route::screen($slug, static::class)
            ->name("platform.$slug.list")
            ->breadcrumbs(fn (Trail $trail) => $trail
                ->parent('platform.index')
                ->push("Listagem de $name", "platform.$slug.list"));
    }

    protected static function routeCreate(string $name, ?string $slug = null)
    {
        if (!$slug) {
            $slug = $name;
        }

        Route::screen("$slug/create", static::class)
            ->name("platform.$slug.create")
            ->breadcrumbs(fn (Trail $trail) => $trail
                ->parent("platform.$slug.list")
                ->push("Cadastrar $name"));
    }

    protected static function routeEdit(string $name, ?string $slug = null)
    {
        if (!$slug) {
            $slug = $name;
        }

        Route::screen("$slug/{model}/edit", static::class)
            ->name("platform.$slug.edit")
            ->breadcrumbs(fn (Trail $trail) => $trail
                ->parent("platform.$slug.list")
                ->push("Editar $name"));
    }

    protected static function routeSingle(string $name, ?string $slug = null)
    {
        if (!$slug) {
            $slug = $name;
        }

        Route::screen("$slug/edit", static::class)
            ->name("platform.$slug.edit")
            ->breadcrumbs(fn (Trail $trail) => $trail
                ->parent('platform.index')
                ->push("Alterar $name"));
    }

    protected static function routeView(string $name, ?string $slug = null)
    {
        if (!$slug) {
            $slug = $name;
        }

        Route::screen("$slug/{model}/view", static::class)
            ->name("platform.$slug.view")
            ->breadcrumbs(fn (Trail $trail) => $trail
                ->parent("platform.$slug.list")
                ->push("Visualizar $name"));
    }

    protected static function routeImport(string $name, ?string $slug = null)
    {
        if (!$slug) {
            $slug = $name;
        }

        Route::screen("$slug/import", static::class)
            ->name("platform.$slug.import")
            ->breadcrumbs(fn (Trail $trail) => $trail
                ->parent("platform.$slug.list")
                ->push("Importar $name"));
    }

    protected function toggleField(ModulesModel $model)
    {
        $permissionSlug = static::permissionSlug();
        if ($permissionSlug) {
            checkAuth("platform.$permissionSlug.edit");
        }

        $column = request()->input('params.column');
        $status = request()->input('params.status');

        $model->fill([
            $column => $status,
        ]);

        $model->save();

        logsRestrita()->insertLog(
            sprintf(
                "Alterou %s d%s %s %s para %s",
                $column,
                $model->getArticle(),
                $model->getEntityNameSingular(),
                $model->getLogName(),
                intval($status),
            ),
            "toggleField",
            $model::class,
            $model->id,
        );

        return response()->json([
            'error' => null,
            'message' => 'Status alterado com sucesso',
        ]);
    }

    protected function sortModel($class)
    {
        $permissionSlug = static::permissionSlug();
        if ($permissionSlug) {
            checkAuth("platform.$permissionSlug.edit");
        }

        $data = request()->input('params.data');

        foreach ($data as $id => $new_order) {
            $model = $class::where('id', $id)->first();
            if ($model) {
                $model->order = $new_order;
                $model->save();
            }
        }

        return '';
    }

    public function searchRedirect()
    {
        $data = request()->input();

        if (!empty($data['_token'])) {
            unset($data['_token']);
        }

        return redirect(route($this->url_list, $data));
    }

    public function removeFilters()
    {
        return redirect(route($this->url_list));
    }

    protected function hasFilters()
    {
        return !empty(request()->input('filter'));
    }

    protected static function permissionSlug() : string
    {
        return '';
    }

    protected function editScreenName($model, $nome, $checkPermission = true)
    {
        $permissionSlug = static::permissionSlug();
        if (!$permissionSlug) {
            $checkPermission = false;
        }

        if (request('duplicate')) {
            $permission  = "platform.$permissionSlug.create";
            $screenName = 'Duplicando $nome';
        }
        else if ($model->exists) {
            $permission  = "platform.$permissionSlug.edit";
            $screenName = "Editando $nome";
        }
        else {
            $permission  = "platform.$permissionSlug.create";
            $screenName = "Criando $nome";
        }

        if ($checkPermission) {
            checkAuth($permission);
        }
        return $screenName;
    }
}
