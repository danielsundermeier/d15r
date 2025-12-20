<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsSourceToTweetsTable extends Migration
{
    public function up()
    {
        Schema::table('tweets', function (Blueprint $table) {
            $table->string('source')->after('type');
        });
    }

    public function down()
    {
        Schema::table('tweets', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
}
