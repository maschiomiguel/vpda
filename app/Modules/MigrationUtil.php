<?php

namespace App\Modules;

use Illuminate\Database\Schema\Blueprint;

class MigrationUtil
{
    public static function order(Blueprint $table)
    {
        $table->unsignedInteger('order')->default(999);
    }

    public static function slug(Blueprint $table)
    {
        $table->string('slug')->nullable();
        $table->index('slug');
    }

    public static function translationsColumns(Blueprint $table, string $table_name, string $column_name)
    {
        $table->unsignedBigInteger($column_name);
        $table->string('locale');

        $table->unique([$column_name, 'locale'], "rel_{$table_name}_languages");

        $table->index($column_name);
        $table->index('locale');

        $table->foreign($column_name, "rel_{$table_name}_lang_id")->references('id')->on($table_name)->onUpdate('cascade')->onDelete('cascade');
        $table->foreign('locale', "rel_{$table_name}_lang_locale")->references('locale')->on('languages')->onUpdate('cascade')->onDelete('restrict');
    }

    /**
     * Auxilia na criação dos campos Fulltext
     */
    public static function fullTextColumns(Blueprint $table, string $table_name, array|string $columns)
    {

        if (!is_array($columns)) {
            $columns = [$columns];
        }

        foreach ($columns as $key => $column) {
            $table->mediumtext($column)->nullable();
        }

        if (empty($slug)) {
            $slug = rand(0, 99999999);
        }

        $table->fullText($columns, "{$table_name}_fulltext");
    }
}
