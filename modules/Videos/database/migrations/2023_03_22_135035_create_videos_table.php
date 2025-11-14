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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('order')->default(9999);
            $table->string('code')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->timestamps();

            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->decimal('height', 10, 2)->nullable();
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
        });
        
        Schema::create('videos_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('short_title')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->mediumtext('text')->nullable();
            $table->mediumtext('short_text')->nullable();
            $table->string('video')->nullable();
            $table->integer('hits')->default(0);
            $table->string('color')->nullable();
            MigrationUtil::translationsColumns($table, 'videos', 'video_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos_translations');
        Schema::dropIfExists('videos');
    }
};
