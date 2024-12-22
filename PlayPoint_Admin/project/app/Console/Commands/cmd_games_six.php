<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\games;
use App\Models\tournaments;
use App\Models\live_tournaments;
use App\Models\leaders;
use App\Models\User;
use App\Models\trackers;
use OneSignal;

class cmd_games_six extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmd:six';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(live_tournaments::Where('game_time',1)->where('status',0)->exists()){
            $live_tournaments = live_tournaments::Where('game_time',1)->where('status',0)->get();

            foreach($live_tournaments as $live_tournament){
                $update_live_t = live_tournaments::find($live_tournament->id);
                $update_live_t->status = 1;
                $tournament = tournaments::find($live_tournament->t_id);
                if($tournament->type==1){
                    $tournament->type=2;
                    $tournament->save();
                }
                $update_live_t->save();

                $leaders = leaders::Where('live_t_id',$live_tournament->id)->limit(3)->orderBy('score', 'DESC')->get();
                $place = 0;
                $msg = "0";
                foreach($leaders as $leader){
                    $place++;
                    if(User::Where('id',$leader->uid)->exists()){
                        $add_track = new trackers;
                        $user = User::find($leader->uid);
                        $user->wins+= 1;
                        if($place==1){
                            $user->points+=$live_tournament->one;
                            $add_track->trans_from = 'Tournament' .' first'. ' place';
                            $msg = 'Tournament' .' first'. ' place';
                            $add_track->amount = $live_tournament->one;
                        }elseif($place==2){
                            $user->points+=$live_tournament->two;
                            $add_track->trans_from = 'Tournament' .' second'. ' place';
                            $msg  = 'Tournament' .' second'. ' place';
                            $add_track->amount = $live_tournament->two;
                        }elseif($place==3){
                            $user->points+=$live_tournament->three;
                            $add_track->trans_from = 'Tournament' .' third'. ' place';
                            $msg = 'Tournament' .' third'. ' place';
                            $add_track->amount = $live_tournament->three;
                        }
                        $add_track->uid = $leader->uid;
                        $add_track->type = 0;
                        $add_track->extra = $leader->uid;
                        $add_track->time = time();
                        $user->xp+=rand(100,200);
                        $user->save();
                        $add_track->save();

/*                         $params = [];
                         $params['headings'] = [ "en"=>"Congratulations!" ];
                        OneSignal::addParams($params)->sendNotificationToExternalUser(
                            $msg,
                            $user->uid
                        );*/

                    }
                }
            }




        }


        if(tournaments::Where('game_time',1)->where('status',0)->exists()){
            $tournaments = tournaments::Where('game_time',1)->where('status',0)->where('type',0)->orWhere('type',1)->get();
            foreach($tournaments as $tournament){
                $add_new_tournament = new live_tournaments;
                $add_new_tournament->t_id = $tournament->id;
                $add_new_tournament->one = $tournament->one;
                $add_new_tournament->two = $tournament->two;
                $add_new_tournament->three = $tournament->three;
                $add_new_tournament->game_time = $tournament->game_time;
                $add_new_tournament->start_at = time();
                $add_new_tournament->status = 0;
                $add_new_tournament->save();
            }
        }else{
            info("test command");
        }


        return 0;
    }
}
