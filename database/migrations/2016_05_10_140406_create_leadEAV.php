<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadEAV extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lead_id');
            $table->string('key');
            $table->string('value',2083);
            $table->timestamps();
            $table->engine = 'InnoDB';
            #$table->unique(['lead_id','key','value']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lead_info');
    }
}
