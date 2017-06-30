<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $table = 'leagues';

    protected $fillable = [
		'league_id', 
		'name', 
		'is_cup', 
		'order', 
		'current_season_id', 
		'current_round_id', 
		'current_stage_id', 
		'country_id'
	];	
}
