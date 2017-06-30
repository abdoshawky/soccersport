<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $table = 'seasons';

    protected $fillable = [
		'season_id', 
		'name', 
		'is_current_season', 
		'current_round_id', 
		'current_stage_id', 
		'league_id'
	];	
}
