<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agent_id');
            $table->integer('sphere_id');
            $table->integer('opened')->default(0);
            $table->string('email')->nullable();
            $table->integer('customer_id');
            $table->string('name')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('bad')->default(false);
            $table->date('date')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            //$table->unique(['agent_id','phone']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('leads');
    }
}
