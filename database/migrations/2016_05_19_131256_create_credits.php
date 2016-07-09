<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agent_id');
            $table->float('buyed');
            $table->float('earned');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('credit_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bill_id');
            $table->float('deposit');
            $table->integer('source');
            $table->integer('operator_id');
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
        Schema::drop('credits');
        Schema::drop('credit_history');
    }
}
