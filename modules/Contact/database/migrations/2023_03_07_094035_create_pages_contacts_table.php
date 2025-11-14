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
        Schema::create('pages_contact', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        Schema::create('pages_contact_translations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            MigrationUtil::translationsColumns($table, 'pages_contact', 'page_contact_id');
            
            $table->mediumtext('description')->nullable();
            $table->mediumtext('keywords')->nullable();
            
            $table->string('title')->nullable();
            $table->string('title_1')->nullable();
            $table->string('title_2')->nullable();
            $table->string('title_3')->nullable();
            $table->string('title_4')->nullable();
            
            $table->mediumtext('text')->nullable();
            $table->mediumtext('text_1')->nullable();
            $table->mediumtext('text_2')->nullable();
            $table->mediumtext('text_3')->nullable();
            $table->mediumtext('text_4')->nullable();
            
            $table->string('video')->nullable();
            $table->string('video_1')->nullable();
            $table->string('video_2')->nullable();
            $table->string('video_3')->nullable();
            $table->string('video_4')->nullable();

            $table->json('adresses')->nullable();
            $table->json('iframes_links')->nullable();
            $table->json('phones')->nullable();
            $table->json('emails')->nullable();
            $table->json('whatsapps')->nullable();
            $table->json('social_networks')->nullable();
            $table->json('site_messages_destinies')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_contact_translations');
        Schema::dropIfExists('pages_contact');
    }
};
