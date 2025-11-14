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
        Schema::create('galleries_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->integer('order')->default(9999);
            $table->boolean('active')->default(true);
        });
        Schema::create('galleries_categories_translations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            MigrationUtil::translationsColumns($table, 'galleries_categories', 'gallery_category_id');
            
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galleries_categories_translations');
        Schema::dropIfExists('galleries_categories');
    }
};
