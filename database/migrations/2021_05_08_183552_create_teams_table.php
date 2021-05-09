<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();

            //create the table for the league data
            
            $table->string('teamName');
            $table->integer('teamID');
            $table->string('leagueName');
            $table->integer('leagueID');
            //not all sports/leagues have this data
            $table->integer('rank')->nullable();
            $table->integer('goalsFor')->nullable();
            $table->integer('goalsAgainst')->nullable();
            $table->integer('goalsDiff')->nullable();
            $table->integer('wins')->nullable();
            $table->integer('losses')->nullable();
            $table->integer('draws')->nullable();
            $table->integer('points')->nullable();
            $table->string('stadiumName')->nullable();
            $table->string('website')->nullable();
            $table->string('desc')->nullable();


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
        Schema::dropIfExists('teams');
    }
}
