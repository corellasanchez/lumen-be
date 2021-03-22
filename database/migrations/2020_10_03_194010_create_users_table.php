<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('birthday')->nullable();
            $table->string('country', 2)->nullable();
            $table->string('document_number', 100)->nullable();
            $table->string('document_type', 20)->nullable();
            $table->string('email')->unique()->notNullable();
            $table->string('fullname')->nullable();
            $table->string('gender', 1)->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('users');
    }
}
