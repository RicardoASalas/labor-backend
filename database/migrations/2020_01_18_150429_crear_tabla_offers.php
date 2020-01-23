<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaOffers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('comp_id')->unsigned();
            $table->string('title');
            $table->string('description');
            $table->string('sector');
            $table->string('experience');
            $table->string('salary');
            $table->string('contract_type');
            $table->integer('vacants');
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('province_id')->unsigned();
            $table->integer('promotion_level');
            $table->boolean('is_active');
            $table->timestamps();

            $table->foreign('comp_id')->references('id')->on('companies');
            $table->foreign('province_id')->references('id')->on('provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
