<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{

    public function createBoard(Request $request){

        $validator = Validator::make($request->all(), [
            'player1' => 'required',
            'player2' => 'required',
            'board_size' => 'required',
            'match_count' => 'required'            
        ]);

        if($validator->fails()){
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $data = [];
        $data['player1'] = $request->player1;
        $data['player2'] = $request->player2;
        $data['board_size'] = $request->board_size;
        $data['match_count'] = $request->match_count;

        session(['data'=> $data]);
        session(['winner'=> 'none']);

        session(['player1_matches'=> []]);
        session(['player2_matches'=> []]);

        return redirect()->back();
    }

    public function resetBoard(){

        session()->forget('data');
        return redirect()->back();
    }

    public function checkMatch(Request $request){

        $player1_matches = session('player1_matches');
        $player2_matches = session('player2_matches');

        $match_count = session('data')['match_count'];

        if($request->player == 'p1'){

            array_push($player1_matches, $request->tile_id);
            session(['player1_matches'=> $player1_matches]);

            return response()->json(['success'=> session('player1_matches')]); 
        }

        if($request->player == 'p2'){

            array_push($player2_matches, $request->tile_id);
            session(['player2_matches'=> $player2_matches]);

            return response()->json(['success'=> session('player2_matches')]); 
        }

        
    }
}
