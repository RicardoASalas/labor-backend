<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaEmployeeSkills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeSkills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('emp_id')->unsigned();
            $table->integer('level')->unsigned();
            $table->boolean('is_tested')->default(0);

            $table->foreign('emp_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeeSkills');
    }
}
