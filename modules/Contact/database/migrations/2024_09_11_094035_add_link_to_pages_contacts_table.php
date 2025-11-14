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
        Schema::table('pages_contact_translations', function (Blueprint $table) {         
            $table->string('sitelink')->nullable();
            $table->string('buttontext')->nullable();
            
        });
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages_contact_translations', function (Blueprint $table) {         
            $table->dropColumn('sitelink');
            $table->dropColumn('buttontext');
        });
        
    }
};
