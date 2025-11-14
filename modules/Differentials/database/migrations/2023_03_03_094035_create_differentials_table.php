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
        Schema::create('differentials', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->integer('order')->default(9999);
            $table->boolean('active')->default(true);
        });
        Schema::create('differentials_translations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            MigrationUtil::translationsColumns($table, 'differentials', 'differential_id');
            
            $table->string('title_1')->nullable();
            $table->string('title_2')->nullable();
            
            $table->text('text_1')->nullable();
            $table->text('text_2')->nullable();
            $table->text('text_3')->nullable();
            $table->text('text_4')->nullable();
            
            $table->string('link_1')->nullable();
            $table->string('link_2')->nullable();
            $table->string('link_3')->nullable();
            $table->string('link_4')->nullable();
            
            $table->string('text_link_1')->nullable();
            $table->string('text_link_2')->nullable();
            $table->string('text_link_3')->nullable();
            $table->string('text_link_4')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('differentials_translations');
        Schema::dropIfExists('differentials');
    }
};
