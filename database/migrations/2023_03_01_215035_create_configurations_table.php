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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('email_authenticated')->default(0);
            $table->mediumtext('email_dsn')->nullable();
            $table->string('email_from')->nullable();
        });
        Schema::create('configurations_translations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            MigrationUtil::translationsColumns($table, 'configurations', 'configuration_id');
            
            $table->mediumtext('description')->nullable();
            $table->mediumtext('keywords')->nullable();
            
            $table->mediumtext('custom_js_head')->nullable();
            $table->mediumtext('custom_js_body')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configurations_translations');
        Schema::dropIfExists('configurations');
    }
};
