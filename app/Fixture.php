<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $table = 'fixtures';

    protected $fillable = [
    	'fixture_id',
		'date', 
		'data'
	];	
}
