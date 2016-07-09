<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSphereStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sphere_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sphere_id');
            $table->string('stepname');
            $table->boolean('minmax');
            $table->float('percent');
            $table->integer('position');
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
        Schema::drop('sphere_statuses');
    }
}
