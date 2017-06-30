<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
		'country_id', 'name', 'continent', 'sub_region', 'world_region', 'fifa', 'longitude', 'latitude'
	];	
}
