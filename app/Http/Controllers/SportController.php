<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import http so I can send requests to third party api found in google doc 
use Illuminate\Support\Facades\Http;

//import the sport model
use App\Models\Sport;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //show all the sports
        return Sport::all();
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
        $response = Http::get('https://www.thesportsdb.com/api/v1/json/1/all_sports.php');
        //decode the json response from get the request into a php object
        $rawSports = json_decode($response->body());
        //access the array of sports
        $sports = $rawSports->sports;

        //loop through all the sports in the array doing the following:
        foreach($sports as $sport){
            //using the sport model create a new sport
            $newSport = new Sport;
            //get the sports name 
            $newSport->sportName = $sport->strSport;
            //get the sports ID
            $newSport->sportID = $sport->idSport;
            //save that sport with its name and ID into the database
            $newSport->save();
        }
        //redirect to the sports view all endpoint to confirm the sports have been added to the database
        return redirect('api/sports')->with('success', 'All good!');
    }
}
