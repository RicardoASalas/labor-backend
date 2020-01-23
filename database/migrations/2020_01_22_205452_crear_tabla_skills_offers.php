<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaSkillsOffers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills_offers', function (Blueprint $table) {
            $table->bigInteger('skill_id')->unsigned();
            $table->bigInteger('offer_id')->unsigned();

            $table->foreign('skill_id')->references('id')->on('skills');
            $table->foreign('offer_id')->references('id')->on('offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills_offers');
    }
}
