<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsCategoryAndNotesUrlToGuidesTable extends Migration
{
    public function up()
    {
        Schema::table('guides', function (Blueprint $table) {
            $table->unsignedTinyInteger('sort')->default(0)->after('slug');
            $table->string('category_slug')->nullable()->after('title');
            $table->string('notes_url')->nullable()->after('category_slug');
        });
    }

    public function down()
    {
        Schema::table('guides', function (Blueprint $table) {
            $table->dropColumn('sort');
            $table->dropColumn('category_slug');
            $table->dropColumn('notes_url');
        });
    }
}
