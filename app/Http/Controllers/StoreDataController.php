<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use SoccerAPI;
use YandexTranslate;
use Session;
use DateTime;

use App\Continent;
use App\Country;
use App\League;
use App\Season;
use App\Fixture;

class StoreDataController extends Controller
{
    // public function store_continents(){
    // 	$continents = SoccerAPI::continents()->all();
    // 	// dd($continents);
    // 	foreach ($continents as $continent) {
    // 		$data['name'] = translateToAr($continent->name);
    // 		if(Continent::where('name',$data['name'])->count() == 0)
    // 			Continent::create($data);
    // 	}
    // 	dd(Continent::all());
    // }

    public function store_countries(){

    	$countries = SoccerAPI::countries()->setInclude('leagues')->all();
    	// $countries = SoccerAPI::leagues()->all();
    	// dd($countries);
    	foreach ($countries as $country) {
    		$data['country_id'] 	= $country->id;
    		$data['name'] 			= translateToAr($country->name);
    		$data['continent']		= is_object($country->extra) ? translateToAr($country->extra->continent) : null;
    		$data['sub_region'] 	= is_object($country->extra) ? translateToAr($country->extra->sub_region) : null;
    		$data['world_region'] 	= is_object($country->extra) ? $country->extra->world_region : null;
    		$data['fifa'] 			= is_object($country->extra) ? $country->extra->fifa : null;
    		$data['longitude']		= is_object($country->extra) ? $country->extra->longitude : null;
    		$data['latitude']		= is_object($country->extra) ? $country->extra->latitude : null;
    		
    		// save country data
    		if(Country::where('country_id',$data['country_id'])->count() == 0){
    			Country::create($data);
    		}

    		// save country leagues 
			$leagues = collect($country->leagues->data)->reverse();
			foreach ($leagues as $league) {
				// dd($league);
				$leagueData['league_id'] 			= $league->id;
				$leagueData['name'] 				= translateToAr($league->name);
				$leagueData['is_cup'] 				= $league->is_cup;
				$leagueData['current_season_id'] 	= $league->current_season_id;
				$leagueData['current_round_id'] 	= $league->current_round_id;
				$leagueData['current_stage_id'] 	= $league->current_stage_id;
				$leagueData['country_id'] 			= $league->country_id;

				if(League::where('league_id',$leagueData['league_id'])->count() == 0){
					League::create($leagueData);
				}

			}
    	}

    	dd(Country::all());
    }

    public function store_seasons(){
    	$seasons = SoccerAPI::seasons()->all();
    	dd($seasons);
    	foreach ($seasons as $season) {
    		$data['season_id'] 			= $season->id;
    		$data['name'] 				= $season->name;
    		$data['league_id']			= $season->league_id;
    		$data['is_current_season'] 	= $season->is_current_season;
    		$data['current_round_id'] 	= $season->current_round_id;
    		$data['current_stage_id'] 	= $season->current_stage_id;
    		
    		if(Season::where('season_id',$data['season_id'])->count() == 0)
    			Season::create($data);
    	}

    	dd(Season::all());
    }

    public function store_fixtures(){
        $player = SoccerAPI::teams()->setInclude('squad')->byId('2');
        dd($player);
        // dd(date_diff(date_create('2017-06-30'),date_create('2017-06-28'))->days);
        // dd(Fixture::orderBy('date','desc')->first());
        // dd( 147 % 100 );
        // the first date stored in api 
        if(Session::get('start_date') == ''){
            Session::put('start_date',new DateTime('2005-03-07'));    
        }
        
        $start_date = Session::get('start_date');
        // dd($start_date);
        $end_date   = new DateTime(date('Y-m-d'));
        $diffDays   = date_diff($start_date,$end_date)->days;
        for($i = 0 ; $i < 20; $i++){
            $start_date->modify("+1 day");
            Session::put('start_date',new DateTime($start_date->format('Y-m-d')));    
            echo $start_date->format('Y-m-d').'<br>';
        }
        var_dump(Session::get('start_date'));
        dd($diffDays);
        

        // count years 2005 - 2006 - 2007 - ....
        for($year = $s_year; $year <= $e_year; $year++){
            // count monthes 
            for($month = 1; $month <= 12; $month++){
                // count days 
                for($day = 1; $day <= 31; $day++){
                    // search for matches by date to store
                    $date = "$year-$month-$day"; 
                    $page = 1;
                    $fixtures = collect(SoccerAPI::fixtures()->setPage($page)->byDate($date));
                    // check if the count of data euqal to 100 then there still another data
                    while(count($fixtures) > 0 && count($fixtures) % 100 == 0){
                        $page++;
                        $merged_fixtures = $fixtures->merge(collect(SoccerAPI::fixtures()->setPage($page)->byDate($date)));
                        $fixtures = $merged_fixtures;
                    }

                    // save data
                    foreach ($fixtures as $fixture) {
                        if(Fixture::where('fixture_id',$fixture->id)->count() == 0){
                            $data['date']           = $date;
                            $data['fixture_id']     = $fixture->id;
                            $data['data']           = json_encode($fixture);
                            Fixture::create($data);
                        }
                    }
                    // dd(count($fixtures));
                }
            }
        } 

     //    dd($s_year);
    	// $fixtures = SoccerAPI::fixtures()->setPage(1)->byDate($date);
     //    foreach ($fixtures as $fixture) {
     //        if(Fixture::where('fixture_id',$fixture->id)->count() == 0){
     //            $data['date']           = $date;
     //            $data['fixture_id']     = $fixture->id;
     //            $data['data']           = json_encode($fixture);
     //            Fixture::create($data);
     //        }
     //    }
        echo count(Fixture::all());
        dd($fixtures);

        
    	
    	// dd(json_encode($fixtures));
    	// foreach ($seasons as $season) {
    	// 	$data['season_id'] 			= $season->id;
    	// 	$data['name'] 				= $season->name;
    	// 	$data['league_id']			= $season->league_id;
    	// 	$data['is_current_season'] 	= $season->is_current_season;
    	// 	$data['current_round_id'] 	= $season->current_round_id;
    	// 	$data['current_stage_id'] 	= $season->current_stage_id;
    		
    	// 	if(Season::where('season_id',$data['season_id'])->count() == 0)
    	// 		Season::create($data);
    	// }

    	// dd(Season::all());
    }
}
