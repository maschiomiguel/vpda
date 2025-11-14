<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('languages')->insert([
            'id' => 1,
            'name' => 'Português',
            'code' => 'pt',
            'locale' => 'pt-BR',
            'name_in_language' => 'Português',
            'position' => 1,
            'main' => 1,
            'date_format_short' => 'd/m/Y',
            'date_format_long' => "d 'de' F 'de' Y",
            'active' => 1,
            'show' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
		DB::table('languages')->insert([
            'id' => 2,
            'name' => 'Inglês',
            'code' => 'en',
            'locale' => 'en',
            'name_in_language' => 'English',
            'position' => 2,
            'main' => 0,
            'date_format_short' => 'm/d/Y',
            'date_format_long' => "F, dS Y",
            'active' => 0,
            'show' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
		DB::table('languages')->insert([
            'id' => 3,
            'name' => 'Espanhol',
            'code' => 'es',
            'locale' => 'es',
            'name_in_language' => 'Español',
            'position' => 3,
            'main' => 0,
            'date_format_short' => 'd/m/Y',
            'date_format_long' => "d 'de' F 'de' Y",
            'active' => 0,
            'show' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('languages')->delete(1);
        DB::table('languages')->delete(2);
        DB::table('languages')->delete(3);
    }
};
