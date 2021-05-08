<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create the sports table
        Schema::create('sports', function (Blueprint $table) {
            $table->id();

            // in the sports table create the sportId and sportName fields
            //note: neither of these fields can be ommited
            $table->integer('sportID');
            $table->string('sportName');

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
        Schema::dropIfExists('sports');
    }
}
