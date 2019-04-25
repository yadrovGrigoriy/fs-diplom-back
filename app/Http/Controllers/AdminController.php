<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Film;
use App\Models\Hall;
use App\Models\Seance;
use App\Models\Ticket;
use Illuminate\Http\Request;



class AdminController extends Controller
{
    public function getClient(){
    	$client = DB::table('oauth_clients')->first();
    	return  ['client'=> $client];
    }

     public function createHall(Request $request) {
        $hall =  Hall::create(['name' => $request->name]);

        return ['halls' => Hall::all()];
    }

    public function deleteHall(Request $request) {
        $hall = Hall::find($request->id);
        $hall->delete();
        return ['halls' => Hall::all()];
       
    }

    public function updateHall(Request $request) {
        Hall::where('id', $request->id)->update(['rows' => $request->rows, 'chairs' => $request->chairs, 'map'=> $request->map]);

        return ['halls' => Hall::all()];  
    }

    public function updatePricesHall(Request $request) {
        Hall::where('id', $request->id)->update(['price' => $request->price, 'price_vip' => $request->vip]);
        return ['halls' => Hall::all()];   
    }

    public function addFilm(Request $request) {
        
        $film = Film::create([
            'title' => $request->title,
            'duration' => $request->duration,
            'description' => $request->description,
            'poster' => $request->poster,
            'country' => $request->country
        ]);
        return ['films' => Film::all()];
    }

    public function deleteFilm(Request $request) {
        Film::where('id', $request->id)->delete();
        return ['films' => Film::all()];
    }
    public function updateFilm(Request $request){
        Film::where('id', $request->film_id)->update([
            'title' => $request->title,
            'duration' => $request->duration,
            'description' => $request->description,
            'poster' => $request->poster,
            'country' => $request->country
        ]);
        return ['films' => Film::all()];
    }

    public function addSeances(Request $request){
        $seances = json_decode($request->seances) ;
        foreach ($seances as $seance) {
            $newSeance = new Seance();
            $newSeance->time = $seance->time;
            $newSeance->hall_id = $seance->hall_id;
            $newSeance->film_id = $seance->film_id;                    
            $newSeance->save();
        }
        return ['seance' => Seance::all()];
    }    

    public function removeSeances(Request $request){
        
        $removeData = json_decode($request->removeSeances);
        foreach ($removeData as $seanceId) {
            Seance::find($seanceId)->delete();   
        }
        return ['status' => 'ok'];
    }
}
