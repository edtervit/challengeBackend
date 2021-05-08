<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;
    protected $fillable =[
        //create the model to match the table created in the migration
        'leagueID',
        'leagueName',
        'sportName'
    ];
}
