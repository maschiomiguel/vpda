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
        Schema::table('site_emails', function (Blueprint $table) {
            $table->string('solution')->nullable()->after('message');
            $table->string('city')->nullable()->after('solution');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_emails', function (Blueprint $table) {
            $table->dropColumn('solution');
            $table->dropColumn('city');
        });
    }
};
