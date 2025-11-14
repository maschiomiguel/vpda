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
        Schema::create('rel_galleries_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('gallery_category_id');
            $table->unsignedBigInteger('gallery_id');

            $table->primary(['gallery_category_id', 'gallery_id'], 'rel_galleries_categories_pk');

            $table->index('gallery_category_id');
            $table->index('gallery_id');

            $table->foreign('gallery_category_id')->references('id')->on('galleries_categories')->onDelete('cascade');
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rel_galleries_categories');
    }
};
