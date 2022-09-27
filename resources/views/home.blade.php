@extends('layouts.app')
@section('title', 'Home Page | Tic Tac Toe')

@section('content')

<style>
    td{
        height: 60px;
        width: 60px;
        cursor: pointer;
    }
    td:hover{
        background-color: rgba(0, 0, 0, 0.2);
    }

    td{
        border: 1px solid #ccc;
    }

    .tiles{

        font-size: 2rem;
        text-align: center;
        color: #fff;
    }

</style>

<div class="container mb-4">
    <div class="col-md-6 mx-auto">

        @if(Session::has('error'))
            <div class="row d-flex justify-content-center mt-2">                
                <div class="alert alert-danger alert-dismissible fade show m-0 py-3" role="alert">
                    {{Session::get('error')}}
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>                
            </div>
        @endif

        @if(!Session::has('data'))

            <form class="bg-white p-4 shadow-sm mt-3" id="boardForm" action="{{ route('create-board') }}" method="post">
                @csrf
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Player 1 Name</label>
                        <input type="text" name="player1" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Player 2 Name</label>
                        <input type="text" name="player2" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Select board size</label>
                        <select name="board_size" class="form-control" id="board_size">
                            @for($i=3; $i<=10; $i++)
                                <option value="{{$i}}">{{$i}}X{{$i}}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Select match count</label>
                        <select name="match_count" class="form-control" id="match_count">
                            <option value="3">3 rows</option>
                            <option value="4">4 rows</option>
                            <option value="5">5 rows</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button type="button" id="createBtn" class="btn btn-primary">Create Board</button>
                    </div>
                </div>
            </form>
        @else

            <input type="hidden" id="winner" value="{{ Session::get('winner')}}">
        
            <?php

                $data = Session::get('data');

                $letters = ['', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];
            
            ?>
            
            <div class="d-flex justify-content-between mt-4">
                <div>
                    Player 1 (X):
                    <h5 id="player1">{{$data['player1']}}</h5>
                </div>
                <div>
                    Player 2 (O):
                    <h5 id="player2">{{$data['player2']}}</h5>
                </div>            
            </div>

            <div class="d-flex justify-content-between">
                <span id="active_player" class="h5 text-primary fw-bold" data-player="1">{{$data['player1']}}'s turn</span>
                <a class="btn btn-dark btn-sm" href="{{ route('reset-board') }}">Reset Board</a>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <table class="bg-white">
                    <tbody>
                        @for($i=1; $i<=$data['board_size']; $i++)
                        <tr>
                            @for($j=1; $j<=$data['board_size']; $j++)
                                <td class="tiles" data-id="{{$letters[$j].$i}}"></td>
                            @endfor
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>

    $('#createBtn').click(function(){

        var board_size = $('#board_size').find(':selected').val();
        var match_count = $('#match_count').find(':selected').val();
        
        if(parseInt(match_count) > parseInt(board_size)){

            alert('Match count must be less than or equal to '+ board_size);
            return false;

        }else{

            $('#boardForm').submit();
        }           
        
    });

    $('.tiles').click(function(){

        var winner = $('#winner').val();

        if(winner != 'none'){
            return false;
        }

        var tile = $(this);

        if(tile.text() == 'x' || tile.text() == 'o'){
            return false;
        }

        togglePlayer(tile);

    });

    function togglePlayer(tile){

        var p1 = $('#player1').text();
        var p2 = $('#player2').text();

        var active_player = $('#active_player');

        if(active_player.data('player') == 1){

            active_player.data('player', 2);
            active_player.text(p2+"'s turn");

            tile.html('x');
            tile.addClass('bg-dark');

            checkMatch('p1', tile.data('id'));

        }else{

            active_player.data('player', 1);
            active_player.html(p1+"'s turn");

            tile.html('o');
            tile.addClass('bg-primary');

            checkMatch('p2', tile.data('id'));
        }
    }

    function checkMatch(player, id){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
           type:'POST',
           url:"{{ route('check-match') }}",
           data:{player:player, tile_id:id},
            success:function(data){
               
                if(data.status == 201){
                    
                    alert(data.success)
                    $('#winner').val(data.success);

                    if(data.winner == 'p1'){

                        var p1 = $('#player1').text();
                        $('#active_player').text(p1+ ' Wins!');
                        $('#active_player').removeClass('text-primary');
                        $('#active_player').addClass('text-danger');
                    }
                    if(data.winner == 'p2'){

                        var p2 = $('#player2').text();
                        $('#active_player').text(p2+ ' Wins!');
                        $('#active_player').removeClass('text-primary');
                        $('#active_player').addClass('text-danger');
                    }
                }
            }
        });
    }

</script>


@endsection