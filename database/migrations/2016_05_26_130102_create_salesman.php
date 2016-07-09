<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesman_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salesman_id');
            $table->integer('agent_id');
            $table->integer('sphere_id');
            $table->integer('bill_id');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('salesman_info');
    }
}
