<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSphereAttributeOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sphere_attribute_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sphere_attr_id');
            $table->enum('ctype', array('agent', 'lead'));
            $table->enum('_type', array('option', 'validate'));
            $table->string('name');
            $table->string('value');
            $table->string('position');
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
        Schema::drop('sphere_attribute_options');
    }
}
