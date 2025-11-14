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
        $dir = __DIR__.'/../../resources/texts';
        $pt = file_get_contents("$dir/privacy-text-pt.html");
        $en = file_get_contents("$dir/privacy-text-en.html");
        $es = file_get_contents("$dir/privacy-text-es.html");
        DB::table('pages_privacies')->insert([
            'id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
		DB::table('pages_privacies_translations')->insert([
            'id' => 1,
            'page_privacy_id' => 1,
            'locale' => "pt-BR",
            'text' => $pt,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
		DB::table('pages_privacies_translations')->insert([
            'id' => 2,
            'locale' => "en",
            'page_privacy_id' => 1,
            'text' => $en,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
		DB::table('pages_privacies_translations')->insert([
            'id' => 3,
            'locale' => "es",
            'page_privacy_id' => 1,
            'text' => $es,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
		
    }

};
