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
            $table->bigIncrements('id');
            $table->string('licence')->unique()->notNullable();
            $table->string('customer')->nullable();
            $table->date('activated_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->boolean('paid')->default(false);
            $table->string('promo_code')->nullable();
            $table->float('price', 8, 2)->nullable();
            $table->smallInteger('type');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
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
