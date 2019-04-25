<?php

namespace App\Http\Controllers;
use App\Models\Film;
use App\Models\Hall;
use App\Models\Seance;
use App\Models\Ticket;
use DB;


use Illuminate\Http\Request;


class ClientController extends Controller
{
    public function getAll(){   
        $halls = DB::table('halls')
            ->join('seances',  'halls.id', 'seances.hall_id' )
            ->select('seances.film_id', 'halls.name', 'halls.id')
            ->distinct()
            ->get();
        return  [
           'films' => Film::all(),
           'halls' => Hall::all(),
           'hallsByFilms' => $halls,
           'seances' => Seance::all(),
        ];    
    }

    public function getClientHall(Request $request) {
        $seance = Seance::find($request->seance_id);
        $film = Film::find($seance->film_id);
        $hall = Hall::find($seance->hall_id);
        $tickets = Ticket::where('seance_id', $request->seance_id)->get();

        return [
            'seance' => $seance,
            'film' => $film,
            'hall' => $hall,
            'tickets' => $tickets
        ];
    }

    public function addTicket(Request $request) {
        $ticket = new Ticket;
        $ticket->seance_id = $request->seance_id;
        $ticket->reserve = $request->reserve;
        $ticket->total_price = $request->total_price;
        // $ticket->qr_code = $request->qr_code;
        $ticket->save();
        
        return $ticket;
    }
    public function updateTicket(Request $request){
	  		Ticket::where('id', $request->id)->update(['qr_code' => $request->qr_code]);
    		return Ticket::find($request->id); 
    }

    public function getTicket(Request $request){

        $ticket = Ticket::find($request->ticket_id);
        $seance = Seance::find($ticket->seance_id);
        $film = Film::find($seance->film_id);
        $hall = Hall::find($seance->hall_id);
        
        return [
           'ticket' => $ticket,
           'seance' => $seance,
           'film' => $film,
           'hall' => $hall
        ];
    }    

    // public function showTicketClient (Request $request) {
    //     $ticket = Ticket::find($request->ticket_id);
    //     $seance = Seance::find($ticket->seance_id);
    //     $film = Film::find($seance->film_id);
    //     $hall = Hall::find($seance->hall_id);
    //     return  [
    //         'ticket'=> $ticket,
    //         'seance'=>$seance,
    //         'film'=>$film,
    //         'hall'=>$hall
    //         ];
    // }
 
}
