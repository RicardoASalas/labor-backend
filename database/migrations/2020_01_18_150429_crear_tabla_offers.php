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
            $table->bigInteger('company_id')->unsigned();
			
			$table->string('title');
            $table->text('description');
			$table->string('sector');
			
            $table->string('experience');
            $table->integer('min_salary');
			$table->integer('max_salary');
			
			$table->string('contract_type');
			$table->string('workday');
			$table->integer('vacants')-> default(1);
			
            $table->string('city');
            $table->string('province');
            $table->integer('times_applied')->default(0);
			
            // $table->integer('promotion_level');
            $table->boolean('is_active')-> default(1);
            $table->timestamps();

			
			
			$table->foreign('company_id')->references('id')->on('companies');
			
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
