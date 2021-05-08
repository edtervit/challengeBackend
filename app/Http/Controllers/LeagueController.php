<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import the league model
use App\Models\League;

//import http so I can send requests to third party api found in google doc 
use Illuminate\Support\Facades\Http;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //show all the leagues
        return League::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function fetch()
    {
        //send a get request to api supplied in google doc
        $response = Http::get('https://www.thesportsdb.com/api/v1/json/1/all_leagues.php');
        //decode the json response from get the request into a php object
        $rawLeagues = json_decode($response->body());
        //access the array of Leagues
        $leagues = $rawLeagues->leagues;

        //loop through all the Leagues in the array doing the following:
        foreach($leagues as $league){
            //using the League model create a new League
            $newLeague = new League;
            //get the Leagues name 
            $newLeague->leagueName = $league->strLeague;
            //get the Sport name 
            $newLeague->sportName = $league->strSport;
            //get the Leagues ID
            $newLeague->leagueID = $league->idLeague;
            //save that League with its name and ID into the database
            $newLeague->save();
        }
        //redirect to the sports view all endpoint to confirm the sports have been added to the database
        return redirect('api/league')->with('success', 'All good!');
    }
}
