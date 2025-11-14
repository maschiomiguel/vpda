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
        Schema::create('site_emails', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->boolean('sent')->default(0);

            $table->string('form_name')->nullable();
            $table->string('form_slug')->nullable();

            $table->string('entity_name')->nullable();
            $table->string('entity_id')->nullable();

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('subject')->nullable();
            $table->string('link')->nullable();
            $table->string('file')->nullable();
            $table->mediumtext('message')->nullable();
            
            $table->text('job')->nullable();
            $table->text('product')->nullable();
            $table->mediumtext('form_data')->nullable();
            $table->mediumtext('debug')->nullable();

            $table->index('form_name');
            $table->index('form_slug');

            $table->index('entity_name');
            $table->index('entity_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_emails');
    }
};
