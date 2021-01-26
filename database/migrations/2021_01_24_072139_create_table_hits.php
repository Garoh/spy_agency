<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user_assigned');
            $table->string('description');
            $table->string('target');
            $table->integer('status');
            $table->foreignId('id_user_creator');
            $table->timestamps();

            $table->foreign('id_user_assigned')->references('id')->on('users');
            $table->foreign('id_user_creator')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hits');
    }
}
