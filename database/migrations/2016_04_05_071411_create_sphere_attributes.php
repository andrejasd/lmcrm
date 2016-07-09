<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSphereAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sphere_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sphere_id');

            $table->string('_type');
            $table->string('label');
            $table->string('icon',2083);
            $table->string('required');
            $table->string('default_value');
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
        Schema::drop('sphere_attributes');
    }
}
