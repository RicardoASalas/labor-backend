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
            $table->string('publisher_id');
            $table->string('title');
            $table->string('description');
            $table->string('required_skill_1');
            $table->string('required_skill_2');
            $table->string('required_skill_3');
            $table->string('required_skill_4');
            $table->string('required_skill_5');
            $table->string('required_skill_6');
            $table->string('sector');
            $table->string('experience');
            $table->string('salary');
            $table->string('contract_type');
            $table->integer('vacants');
            $table->string('country');
            $table->string('city');
            $table->integer('promotion_level');
            $table->boolean('is_active');
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
        Schema::dropIfExists('offers');
    }
}
