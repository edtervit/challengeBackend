<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import the team model
use App\Models\Team;

//import the league model
use App\Models\League;

//import http so I can send requests to third party api found in google doc 
use Illuminate\Support\Facades\Http;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //show all the teams
        return Team::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create a team to test, used for testing if my find by leagueID is working.
        return Team::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //search the teams table for any team in this league
        return Team::where('leagueID' , $id)->get();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //find the team that has the leagueID and teamID supplied in the body
        //workaround: send POST request with _method=PUT in querystring
               $team = Team::where('leagueID', $request->input("leagueID"))
                    ->where('teamID', $request->input("teamID"))
                    ->firstOrFail();

                    //if it finds the team, update the stadium name, website and description from request body and save
                    $team->stadiumName = $request->input('stadiumName');
                    $team->website = $request->input("website");
                    $team->desc = $request->input("desc");
                    $team->save();                    
                    //this update method is used to add in the data that will be missing from the standings data from google doc api
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete a team by it's Id, used to delete the teams for testing
        return Team::destroy($id);
    }

    public function fetch()
    {

        //change the max execution time to unlimited so it doesn't 404 midway through
        //I understand this isn't the optimal solution but I don't have time to learn how to do queueing
        ini_set('max_execution_time', 0);

        //get all the leagues
        $leagues = League::all();


        //for each league in the database
        foreach($leagues as $league){

            //get the league's ID
            $leagueID = $league->leagueID;

            //send a get request to api supplied in google doc for that leagues teams list
            $response = Http::get('https://www.thesportsdb.com/api/v1/json/1/lookup_all_teams.php?id=' . $leagueID);

            //decode the json response from get the request into a php object
            $rawTeams = json_decode($response->body());


            //check to see if response is not empty as some leagues don't work with the lookup all teams endpoint
            if($rawTeams){

                //access the array of teams
            $teams = $rawTeams->teams;

            //checks to see if this variable is an array or an object as for some teams it was not and erroring out
            if(is_array($teams) or is_object($teams)){
                //loop through all the teams in the array doing the following:
                foreach($teams as $team){
                    //using the team model create a new team
                    $newTeam = new Team;
                    
                    //extract the data about the team
                    //this data is required in the database table
                    $newTeam->teamName = $team->strTeam;
                    $newTeam->teamID = $team->idTeam;
                    $newTeam->leagueName = $team->strLeague;
                    $newTeam->leagueID = $team->idLeague;

                    //if this data is available then add it, if not skip as some sports won't have stadiums e.g darts
                    $newTeam->stadiumName = $team->strStadium;
                    $newTeam->website = $team->strWebsite;
                    $newTeam->desc = $team->strDescriptionEN;

                    //save that team into the database
                    $newTeam->save();
                }
            }
            }
    
            //send another request to the standings 
            $response2 = Http::get('https://www.thesportsdb.com/api/v1/json/1/lookuptable.php?amp%3Bs=2020-2021&l=' . $leagueID);

            //decode the json response from get the request into a php object
            $rawTeams2 = json_decode($response2->body());

            //check to see if response is not empty as most leagues don't work with the standings endpoint
            if($rawTeams2){
                //access the array of teams
                $teams2 = $rawTeams2->table;

                //checks to see if this variable is an array or an object as for some teams it was not and caused errors
                if(is_array($teams2) or is_object($teams2)){
                    //loop through all the teams in the array doing the following:
                    foreach($teams2 as $team2){
                        //find the Team that has matching leagueID and teamID from 
                        $teamFound = Team::where('leagueID', $leagueID )
                            ->where('teamID', $team2->idTeam)
                            ->first();

                            //if this finds the team with matching leagueId and teamID 
                        if($teamFound){
                            //extract the data about the teams standings and save it into their database record
                            $teamFound->rank = $team2->intRank;
                            $teamFound->goalsFor = $team2->intGoalsFor;
                            $teamFound->goalsAgainst = $team2->intGoalsAgainst;
                            $teamFound->goalsDiff = $team2->intGoalDifference;
                            $teamFound->wins = $team2->intWin;
                            $teamFound->losses = $team2->intLoss;
                            $teamFound->draws = $team2->intDraw;
                            $teamFound->points = $team2->intPoints;

                            //save that team into the database
                            $teamFound->save();
                        }
                    }
                }
            }
        }
        //redirect to the sports view all endpoint to confirm the sports have been added to the database
        return redirect('api/teams')->with('success', 'All good!');
        
        //set the max execution time back to default of 60 seconds
        ini_set('max_execution_time', 60);
    }
}
