<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Orchid\Support\Facades\Dashboard;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Verifica se o usuário admin já existe
        $adminExists = DB::table('users')->where('username', 'admin')->exists();
        
        if (!$adminExists) {
            DB::table('users')->insert([
                'active' => 1,
                'visible' => 1,
                'name' => 'Administrador',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('M@st3r'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'permissions' => Dashboard::getAllowAllPermission(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->where('username', 'admin')->delete();
    }
};
