<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*login', 'city', 'desc', 'avatar', 'street', 'postal', 'banned_to', 'first_login', 'birth_date'*/
        Schema::table('users', function (Blueprint $table) {
            $table->string('login')->nullable();
            $table->string('city')->nullable();
            $table->longText('desc')->nullable();
            $table->string('street')->nullable();
            $table->string('postal')->nullable();
            $table->dateTime('banned_to')->default(null)->nullable();
            $table->boolean('first_login')->default(true);
            $table->date('birth_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
