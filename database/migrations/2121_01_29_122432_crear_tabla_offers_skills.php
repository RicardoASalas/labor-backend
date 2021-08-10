<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaOffersSkills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers_skills', function (Blueprint $table) {
            $table->bigInteger('offer_id')->unsigned();
            $table->bigInteger('skill_id')->unsigned();

			
			
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('skill_id')->references('id')->on('skills');


            
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers_skills');
    }
}
