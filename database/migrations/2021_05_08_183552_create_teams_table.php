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
            $table->integer('rank');
            $table->integer('goalsFor');
            $table->integer('goalsAgainst');
            $table->integer('goalsDiff');
            $table->integer('wins');
            $table->integer('losses');
            $table->integer('draws');
            $table->integer('points');
            //make these nullable so doesn't fail on initial import of teams but can be updated later when importing team details 
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
