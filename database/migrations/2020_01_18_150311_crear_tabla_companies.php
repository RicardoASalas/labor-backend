<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('username')->unique();
            $table->string('password');
			
            $table->string('name');
            $table->string('sector');
			$table->string('description') -> default("");
			
            $table->string('email')->unique();
            $table->string('phone');
			$table->string('website') -> default("");
			
            $table->string('avatar_url') -> default("");
			$table->string('cif')->unique() -> default("");
			
			$table->boolean("is_company");
			$table->string("uid");
			
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
        Schema::dropIfExists('companies');
    }
}
