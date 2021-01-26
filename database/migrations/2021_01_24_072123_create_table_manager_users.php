<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableManagerUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user_manager');
            $table->foreignId('id_user_hitmen');
            $table->timestamps();

            $table->foreign('id_user_manager')->references('id')->on('users');
            $table->foreign('id_user_hitmen')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manager_users');
    }
}
