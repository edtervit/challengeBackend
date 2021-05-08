<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import the league model
use App\Models\Team;

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
}
