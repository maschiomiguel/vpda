<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Modules\MigrationUtil;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_home', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        Schema::create('pages_home_translations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            MigrationUtil::translationsColumns($table, 'pages_home', 'page_home_id');
            
            $table->mediumtext('description')->nullable();
            $table->mediumtext('keywords')->nullable();
            
            $table->string('title')->nullable();
            $table->string('title_1')->nullable();
            $table->string('title_2')->nullable();
            $table->string('title_3')->nullable();
            $table->string('title_4')->nullable();
            $table->string('title_5')->nullable();
            $table->string('title_6')->nullable();
            
            $table->mediumtext('text')->nullable();
            $table->mediumtext('text_1')->nullable();
            $table->mediumtext('text_2')->nullable();
            $table->mediumtext('text_3')->nullable();
            $table->mediumtext('text_4')->nullable();
            $table->mediumtext('text_5')->nullable();
            $table->mediumtext('text_6')->nullable();
            
            $table->string('video')->nullable();
            $table->string('video_1')->nullable();
            $table->string('video_2')->nullable();
            $table->string('video_3')->nullable();
            $table->string('video_4')->nullable();
            $table->string('video_5')->nullable();
            $table->string('video_6')->nullable();
            
            $table->mediumtext('call_text')->nullable();
            $table->mediumtext('call_text_1')->nullable();
            $table->mediumtext('call_text_2')->nullable();
            $table->mediumtext('call_text_3')->nullable();
            $table->mediumtext('call_text_4')->nullable();
            $table->mediumtext('call_text_5')->nullable();
            $table->mediumtext('call_text_6')->nullable();
            
            $table->string('call_link')->nullable();
            $table->string('call_link_1')->nullable();
            $table->string('call_link_2')->nullable();
            $table->string('call_link_3')->nullable();
            $table->string('call_link_4')->nullable();
            $table->string('call_link_5')->nullable();
            $table->string('call_link_6')->nullable();
            
            $table->string('call_text_link')->nullable();
            $table->string('call_text_link_1')->nullable();
            $table->string('call_text_link_2')->nullable();
            $table->string('call_text_link_3')->nullable();
            $table->string('call_text_link_4')->nullable();
            $table->string('call_text_link_5')->nullable();
            $table->string('call_text_link_6')->nullable();
            
            $table->json('values')->nullable();
            $table->json('count_up')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_home_translations');
        Schema::dropIfExists('pages_home');
    }
};
