<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make('DashBoard')
                ->icon('bar-chart')
                ->route('platform.main'),

            Menu::make('Página Principal')
                ->icon('menu')
                ->route('platform.pageshome.edit'),

            Menu::make('Depoimentos')
                ->route('platform.testimonials.list')
                ->permission('platform.testimonials.list'),

            Menu::make('Diferenciais')
                ->icon('layers')
                ->route('platform.differentials.list')
                ->permission('platform.differentials.list'),

            Menu::make('Posts do Instagram')
                ->icon('picture')
                ->route('platform.galleries.list')
                ->permission('platform.galleries.list'),

            Menu::make('Reels do Instagram')
                ->icon('film')
                ->route('platform.videos.list')
                ->permission('platform.videos.list'),

            Menu::make('FAQ')
                ->icon('question')
                ->route('platform.questions.list')
                ->permission('platform.questions.list'),

            Menu::make('Contato')
                ->icon('phone')
                ->route('platform.pagescontact.edit')
                ->permission('platform.pagescontact.edit'),

            Menu::make('Política de privacidade')
                ->icon('shield')
                ->route('platform.pagesprivacy.edit')
                ->permission('platform.pagesprivacy.edit'),

            Menu::make('Administração')
                ->icon('settings')
                ->permission([
                    'platform.configurations.edit',
                    'platform.systems.users',
                    'platform.systems.roles',
                    'platform.systems.logs',
                ])
                ->list([
                    Menu::make("Configurações")
                        ->route('platform.configurations.edit')
                        ->permission('platform.configurations.edit'),

                    Menu::make(__('Users'))
                        ->route('platform.systems.users')
                        ->permission('platform.systems.users'),

                    Menu::make(__('Níveis'))
                        ->route('platform.systems.roles')
                        ->permission('platform.systems.roles'),

                    Menu::make("Logs")
                        ->route('platform.systems.logs')
                        ->permission('platform.systems.logs'),
                ]),

        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make(__('Profile'))
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        $permissions = [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users'))
                ->addPermission('platform.systems.logs', __('Logs')),
        ];

        foreach (screens()->permissions() as $permission) {
            $permissions[] = $permission;
        }

        return $permissions;
    }
}
