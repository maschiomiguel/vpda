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
        Schema::table('pages_home_translations', function (Blueprint $table) {
            $table->mediumtext('text_7')->nullable()->after('text_6');
            $table->mediumtext('title_7')->nullable()->after('title_6');
            $table->mediumtext('text_8')->nullable()->after('text_7');
            $table->mediumtext('title_8')->nullable()->after('title_7');
            $table->mediumtext('text_9')->nullable()->after('text_8');
            $table->mediumtext('title_9')->nullable()->after('title_8');
            $table->mediumtext('text_10')->nullable()->after('text_9');
            $table->mediumtext('title_10')->nullable()->after('title_9');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages_home_translations', function (Blueprint $table) {
            $table->dropColumn(['text_7', 'title_7', 'text_8', 'title_8', 'text_9', 'title_9', 'text_10', 'title_10']);
        });
    }
};
