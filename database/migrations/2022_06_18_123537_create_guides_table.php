<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();

            $table->string('directory');
            $table->string('slug')->nullable();

            $table->string('title')->nullable();

            $table->boolean('has_spickzettel')->default(false);
            $table->boolean('has_integration')->default(false);
            $table->boolean('has_umsetzung')->default(false);
            $table->boolean('has_handbuch')->default(false);

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
        Schema::dropIfExists('guides');
    }
}
