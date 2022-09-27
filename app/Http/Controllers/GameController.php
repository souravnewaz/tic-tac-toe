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

        session()->flush();
        return redirect()->back();
    }

    public function checkMatch(Request $request){

        $letters = ['', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];

        $p1_match_count = 0;
        $p2_match_count = 0;

        $player1_matches = session('player1_matches');
        $player2_matches = session('player2_matches');

        $count = session('data')['match_count'];

        if($request->player == 'p1'){

            array_push($player1_matches, $request->tile_id);
            session(['player1_matches'=> $player1_matches]);

            for($i = 1; $i <= $count; $i++){

                $horizontal_combination = [];
    
                for($j=1; $j<=$count; $j++){

                    if($p1_match_count == $count){

                        return response()->json([
                            'success'=> 'Player 1 wins',
                            'status' => 201,
                            'winner' => 'p1'
                        ]);
                    }

                    if(in_array($letters[$j].$i, $player1_matches)){
                        $p1_match_count += 1;
                    }
                }
            }
        }

        if($request->player == 'p2'){

            array_push($player2_matches, $request->tile_id);
            session(['player2_matches'=> $player2_matches]);

            for($i = 1; $i <= $count; $i++){

                $horizontal_combination = [];
    
                for($j=1; $j<=$count; $j++){

                    if($p2_match_count == $count){

                        return response()->json([
                            'success'=> 'Player 2 wins',
                            'status' => 201,
                            'winner' => 'p2'
                        ]);
                    }

                    if(in_array($letters[$j].$i, $player2_matches)){
                        $p2_match_count += 1;
                    }
                }
            } 
        }

        return response()->json([
            'success'=> 'No winner, keep going.',
            'status' => 200
        ]);        
    }
}
