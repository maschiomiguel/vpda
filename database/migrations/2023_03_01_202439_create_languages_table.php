<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();

			$table->string('name');
			$table->string('code');
			$table->string('locale');
			$table->string('name_in_language');
			$table->integer('position');
			$table->boolean('main')->default(0);
			$table->boolean('active')->default(0);
			$table->boolean('show')->default(0);
			$table->string('date_format_short');
			$table->string('date_format_long');
			
            $table->unique('locale');

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
        Schema::dropIfExists('languages');
    }
};
