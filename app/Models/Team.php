<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'teamName',
        'teamID',
        'leagueName',
        'leagueID',
        'rank',
        'goalsFor',
        'goalsAgainst',
        'goalsDiff',
        'wins',
        'losses',
        'draws',
        'points',
        'stadiumName',
        'website',
        'desc'
    ];
}
