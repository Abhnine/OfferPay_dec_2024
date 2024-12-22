<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\games;
use App\Models\tournaments;
use App\Models\live_tournaments;
use App\Models\leaders;
use App\Models\User;
use DB;

class TournamentController extends Controller
{
    public function live_tournaments(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->where('uid', $request->uid)->exists()) {
        if(live_tournaments::Where('status',0)->exists()){
            $tournaments = live_tournaments::join('tournaments','tournaments.id','=','live_tournaments.t_id')
            ->join('games','games.id','=','tournaments.game_id')
            ->select('live_tournaments.id','live_tournaments.one','live_tournaments.two','live_tournaments.three',
            'live_tournaments.game_time','live_tournaments.start_at',
            'games.title','games.des','games.image','games.image_type','games.game_path','games.screen_type'
            )->where('live_tournaments.status',0)->get();

            $array = array();
            foreach($tournaments as $tournament){
                $index['id'] = $tournament->id;
                $index['one'] = $tournament->one;
                $index['two'] = $tournament->two;
                $index['three'] = $tournament->three;
                $index['game_time'] = $tournament->game_time;
                $index['start_at'] = $tournament->start_at;
                $index['title'] = $tournament->title;
                $index['des'] = $tournament->des;
                $index['image'] = $tournament->image;
                $index['game_path'] = $tournament->game_path;
                $index['screen_type'] = $tournament->screen_type;

                if($tournament->game_time==0){
                    //hour
                      $t_time = 60*60;
                    //$t_time = 60*5;
                }elseif($tournament->game_time==1){
                    //six hour
                    //$t_time = 60*6*60;
                    $t_time = 60*6*60;
                }elseif($tournament->game_time==2){
                    //daily
                    $t_time = 60*24*60;
                }

                $time_left = $tournament->start_at+$t_time-time();
                $index['time_left'] = $time_left-60;

                if($time_left>0){
                    $index['is_live'] = true;
                }else{
                    $index['is_live'] = false;
                }

                if($tournament->image_type==1){
                    $index['is_image'] = true;
                }else{
                    $index['is_image'] = false;
                }

                $index['players'] = leaders::Where('live_t_id', $tournament->id)->count();

                array_push($array,$index);

            }

             return response()->json([
                 'error'=>'false',
                 'data'=>$array,
             ]);

        }else{
            return response()->json([
                'error'=>'true',
            ]);
        }
    }

    }

    public function add_score(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->where('uid', $request->uid)->exists()) {
            if(live_tournaments::Where('id',$request->id)->where('status',0)->exists()){
                $user = User::select('id')->where('uid',$request->uid)->first();
                if(leaders::Where('live_t_id',$request->id)->where('uid',$user->id)->exists()){
                    $leader = leaders::Where('live_t_id',$request->id)->where('uid',$user->id)->first();
                    if($request->score>$leader->score){
                        $leader->score = $request->score;
                        $leader->save();
                    }

                    return response()->json([
                        'error'=>'false',
                    ]);
                }else{
                    $leader = new leaders;
                    $leader->live_t_id = $request->id;
                    $leader->uid = $user->id;
                    $leader->score = $request->score;
                    $leader->save();

                    $user = User::Where('uid',$request->uid)->first();
                    $user->played+= 1;
                    $user->save();

                    return response()->json([
                        'error'=>'false',
                    ]);
                }
            }
        }
    }


    public function top_three(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->where('uid', $request->uid)->exists()) {
            if(live_tournaments::Where('id',$request->id)->where('status',0)->exists()){
                $leaders = leaders::join('users','users.id','=','leaders.uid')->select('users.name','users.xp','leaders.*')->Where('live_t_id',$request->id)->limit(3)->orderBy('score', 'DESC')->get();
                
                $array = array();
                $rank = 0;
                foreach($leaders as $leader){
                    $rank++;
                        $index['rank'] = $rank;
                        $index['score'] = $leader->score;
                        $index['name'] = $leader->name;
                        $level = $leader->xp/500;
                        $level = (int)$level;
                        $index['level'] = $level;
                        array_push($array,$index);

                }
                
                return response()->json([
                    'error'=>'false',
                    'data'=>$array,
                ]);
            }else{
                return response()->json([
                    'error'=>'true',
                ]);
            }
        }
    }

   public function top_players(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->where('uid', $request->uid)->exists()) {
            if(live_tournaments::Where('id',$request->id)->where('status',0)->exists()){
                $game = live_tournaments::join('tournaments','tournaments.id','=','live_tournaments.t_id')
                ->join('games','games.id','=','tournaments.game_id')
                ->select('games.title','games.image','games.game_path')
                ->Where('live_tournaments.id',$request->id)->first();
                $leaders = leaders::join('users','users.id','=','leaders.uid')->select('users.name','users.xp','leaders.*')->Where('live_t_id',$request->id)->orderBy('score', 'DESC')->get();
                $user = User::select('id')->Where('uid',$request->uid)->first();
                $rank = 0;
                $rank_ = '-';
                $score = '-';
                foreach($leaders as $leader){
                    $rank++;
                    if($user->id==$leader->uid){
                        $rank_ = $rank;
                        $score = $leader->score;
                    }
                }
                $array = array();
                $rank = 0;
                foreach($leaders as $leader){
                    $rank++;
                        $index['rank'] = $rank;
                        $index['score'] = $leader->score;
                        $index['name'] = $leader->name;
                        $level = $leader->xp/500;
                        $level = (int)$level;
                        $index['level'] = $level;
                        array_push($array,$index);

                }


                return response()->json([
                    'error'=>'false',
                    'data'=>$array,
                    'rank'=>$rank_,
                    'score'=>$score,
                    'players'=>count($leaders),
                    'title'=>$game->title,
                    'image'=>$game->image,
                    'game_path'=>$game->game_path,
                ]);
            }else{
                return response()->json([
                    'error'=>'true',
                ]);
            }
        }
    }


}
