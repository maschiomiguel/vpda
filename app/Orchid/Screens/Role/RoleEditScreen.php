<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Role;

use App\Orchid\Layouts\Role\RoleEditLayout;
use App\Orchid\Layouts\Role\RolePermissionLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Services\LogsService;
use Orchid\Screen\Layouts\Columns;
use Orchid\Support\Color;

class RoleEditScreen extends Screen
{
    /**
     * @var Role
     */
    public $role;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Role $role
     *
     * @return array
     */
    public function query(Role $role): iterable
    {
        return [
            'role'       => $role,
            'permission' => $role->getStatusPermission(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Gerenciar níveis';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Access rights';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.systems.roles',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('save')
                ->type(Color::SUCCESS())
                ->method('save'),

            Button::make(__('Remove'))
                ->icon('trash')
                ->method('remove')
                ->class('btn btn-default text-danger')
                ->canSee($this->role->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block([
                RoleEditLayout::class,
            ])
                ->title('Nível')
                ->description('Um nível é uma coleção de privilégios (de serviços possivelmente diferentes, como o serviço Usuários, Moderador e assim por diante) que concede aos usuários com esse nível a capacidade de executar certas tarefas ou operações.'),

            Layout::block([
                Layout::rows([
                    Button::make(__('Marcar todos'))
                        ->icon('check')
                        ->type(Color::DEFAULT())
                        ->set('type', 'button')
                        ->set('data-select-all-permissions'),
                    Button::make(__('Desmarcar todos'))
                        ->icon('circle_thin')
                        ->type(Color::DEFAULT())
                        ->set('type', 'button')
                        ->set('data-deselect-all-permissions'),
                ]),
                RolePermissionLayout::class,
            ])
                ->title('Permission/Privilege')
                ->description('A privilege is necessary to perform certain tasks and operations in an area.'),
        ];
    }

    /**
     * @param Request $request
     * @param Role    $role
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Role $role, LogsService $logs)
    {
        $is_new = empty($role->id);

        $request->validate([
            'role.slug' => [
                'required',
                Rule::unique(Role::class, 'slug')->ignore($role),
            ],
        ]);

        $role->fill($request->get('role'));

        $role->permissions = collect($request->get('permissions'))
            ->map(fn ($value, $key) => [base64_decode($key) => $value])
            ->collapse()
            ->toArray();

        $role->save();

        $logs->insertLog(
            $is_new ? "Cadastrou o nível {$role->name}" : "Editou o nível {$role->name}",
            $is_new ? "create" : "edit",
            Role::class,
            $role->id,
        );

        Toast::info(__('Role was saved'));

        return redirect()->route('platform.systems.roles');
    }

    /**
     * @param Role $role
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Role $role)
    {
        $role->delete();

        Toast::info(__('Role was removed'));

        return redirect()->route('platform.systems.roles');
    }
}
