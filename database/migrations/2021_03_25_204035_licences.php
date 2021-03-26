<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Licences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licences', function (Blueprint $table) {
            $table->string('licence')->primary();
            $table->string('customer')->nullable();
            $table->date('activated_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->smallInteger('type');
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
        Schema::dropIfExists('licences');
    }
}
