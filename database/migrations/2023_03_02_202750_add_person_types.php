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
        DB::table('person_types')->insert([
            'id' => 1,
            'name' => 'Pessoa Física',
            'code' => 'f',
            'position' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
		DB::table('person_types')->insert([
            'id' => 2,
            'name' => 'Pessoa Jurídica',
            'code' => 'j',
            'position' => 2,
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
        DB::table('person_types')->delete(1);
        DB::table('person_types')->delete(2);
    }
};
