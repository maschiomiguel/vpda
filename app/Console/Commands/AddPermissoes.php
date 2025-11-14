<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AddPermissoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adiciona todas as permissões para o usuário da Ellite';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('Colocando permissões...');
        
        $user = User::find(2);

        if (!$user) {
            $this->error('Usuário "1" não existe. Rode as migrações antes.');
            return Command::FAILURE;
        }

        $user_permissions = $user->permissions;

        $default_permissions = [
            'platform.index',
            'platform.systems.logs',
            'platform.systems.roles',
            'platform.systems.users',
            'platform.systems.attachment',
        ];
        
        foreach ($default_permissions as $default_permission) {
            $user_permissions[$default_permission] = "1";
        }

        /** @var array<\Orchid\Platform\ItemPermission> */
        $permissions = screens()->permissions();
        foreach ($permissions as $permission) {
            foreach ($permission->items as $group_permissions) {
                $permission = $group_permissions['slug'];
                $user_permissions[$permission] = "1";
            }
        }

        $user->permissions = $user_permissions;

        $user->save();

        $this->info('Permissões adicionadas.');
        return Command::SUCCESS;
    }
}
