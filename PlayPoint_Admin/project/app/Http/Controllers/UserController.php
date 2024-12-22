<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\offers;
use App\Models\offer_lists;
use App\Models\refer_datas;
use App\Models\trackers;
use App\Models\redeems;
use App\Models\offer_status;
use App\Models\rewards;
use App\Models\reward_amounts;
use App\Models\reward_lists;
use App\Models\games;
use App\Models\visits;
use App\Models\daily_task;
use App\Models\ad_setting;
use App\Models\banner;
use App\Models\refer_task;
use App\Models\announce;
use Auth;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Stevebauman\Location\Facades\Location;
use App\Models\leaders;
use OneSignal;
use Image;

class UserController extends Controller
{
    public function get_user(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->exists()) {
            $get_user = DB::table('users')->select('name','email','profile','points','status','refer_id','id','xp','uid','diamond')->where('api_token',$request->token)->first();
            $settings = DB::table('settings')->select('refer_points', 'refer_bonus','vpn','vpn_ban','spin_ad','scratch_ad','back_ad','spin_ad_int','scratch_ad_int','back_ad_int','devOption','x2_ad','game_ad','game_ad_int','referMessage','refer_type')->first();
            $track = trackers::Where('uid',$get_user->id)->Where('trans_from','Daily bonus')->orderBy('time','DESC')->first();
            $refers = trackers::Where('uid',$get_user->id)->Where('trans_from','Referral bonus')->count();
            $redeem = reward_lists::Where('u_id',$get_user->id)->count();
            $total_earn = trackers::Where('uid',$get_user->id)->Where('type',0)->sum('amount');
             $datee = date("Y-m-d");
            $badge = announce::Where('created_at','>',$datee)->count();
            $ad_setting = ad_setting::Where('net_id','fb')->first();
            $adget = ad_setting::Where('net_id','adget')->first();
            
            
            $level = $get_user->xp/500;
            $level = (int)$level;
            $lvlProgress=$get_user->xp-$level*500;
            $xpNeed = 500;
            
            if($level>=5){
                $xp=$get_user->xp-500*5;
                $level2 =$xp/1000;
                $level2 = (int)$level2;
                $lvlProgress=$xp-$level2*1000;
                $xpNeed = 1000;
                $level = $level2+=5;
                
                
                if($level2>=10){
                    $xp_ = 500*5;
                    $xp_2 = 1000*5;
                    $xp__ = $xp_ + $xp_2;
                    $xp2=$get_user->xp-$xp__;
                    $level3 =$xp2/2000;
                    $level3 = (int)$level3;
                    $lvlProgress=$xp2-$level3*2000;
                    $xpNeed = 2000;
                    $level = $level3+=10;
                    
                }
            }
            
            
            $ads = ad_setting::Where('type',0)->get();
            $array = array();
            $myObj = new \stdClass();
            foreach($ads as $ad){
                $ids = json_decode($ad->ids);
                $index[$ad->net_id] = $ids;
                $net = $ad->net_id;
                
                $myObj->$net = $ids;
                
                
            }
            array_push($array,$index);
            $myJSON = json_encode($myObj);

            $fbAd = json_decode($ad_setting->ids);
            $adg = json_decode($adget->ids);
            return response()->json([
                 'error'=>'false',
                'data'=>$get_user,
                'ads'=>$myObj,
                'refer_points'=>$settings->refer_points,
                'level'=>$level,
                'xp_need'=>$xpNeed,
                'lvlProgress'=>$lvlProgress,
                'refers'=>$refers,
                'total_earn'=>$total_earn,
                'redeem'=>$redeem,
                'refer_bonus'=>$settings->refer_bonus,
                'badge'=>$badge,
                'vpn'=>$settings->vpn,
                'vpn_ban'=>$settings->vpn_ban,
                'fb_rewarded'=>$fbAd->reward_ad_id,
                'spin_ad'=>$settings->spin_ad,
                'scratch_ad'=>$settings->scratch_ad,
                'back_ad'=>$settings->back_ad,
                'spin_ad_int'=>$settings->spin_ad_int,
                'scratch_ad_int'=>$settings->scratch_ad_int,
                'back_ad_int'=>$settings->back_ad_int,
                'devOption'=>$settings->devOption,
                'x2_ad'=>$settings->x2_ad,
                'game_ad'=>$settings->game_ad,
                'game_ad_int'=>$settings->game_ad_int,
                'referMessage'=>$settings->referMessage,
                'adget_api'=>$adg->api_status,
                'refer_type'=>$settings->refer_type,
            ]);
        }else
        {
            return response()->json([
                'error'=>'true',
                'message'=>'Given data is wrong!',
            ]);
        }


    }
    
    
        public function check_user(Request $request)
    {


            if (DB::table('users')->where('uid', $request->uid)->exists()) {
                $token = md5(time().'.'.md5($request->uid));
            $update_token = DB::statement("UPDATE `users` SET api_token = '$token' WHERE `uid` = '$request->uid'");
            if($update_token){
                return response()->json([
                    'error'=>'false',
                    'token'=>$token,
                ]);
            }else
            {
                return response()->json([
                    'error'=>'true',
                    'msg'=>'Error in processing!',
                ]);
            }
            }else{
                $request->validate([
                    'uid'=> 'required|unique:users',
                ]);
                
                
            $settings = DB::table('settings')->select('one_device')->first();
                if($settings->one_device==0){
                    if (DB::table('users')->Where('device',$request->device)->exists()){
                        return response()->json([
                                'error'=>'true',
                                'message'=>'This device already associated with another account!',
                        ]);
                    }
                }
                
                

                $randomString = Str::random(8);
                $signup_bonus = 0;
                $ip = $this->gip($request);
                $settings = DB::table('settings')->select('refer_points','refer_bonus')->first();
                $r_id = null;
                $isRefer = false;
                if(refer_datas::Where('ip',$ip)->Where('status',0)->exists()){
                    $r_data = refer_datas::Where('ip',$ip)->Where('status',0)->first();
                    $r_user = User::Where('refer_id',$r_data->refer_id)->first();
                     if(!empty($r_user)){
                    $r_id = $r_user->id;
                    $isRefer = true;

                    $r_user->points += $settings->refer_points;
                    $r_user->t_ref += 1;
                    $r_data->status = 1;

                    $add_track = new trackers;
                    $add_track->uid = $r_user->id;
                    $add_track->trans_from = 'Referral bonus';
                    $add_track->type = 0;
                    $add_track->ip = $ip;
                    $add_track->amount = $settings->refer_points;
                    $add_track->extra = $request->uid;
                    $add_track->time = time();

                    $r_user->save();
                    $r_data->save();
                    $add_track->save();
                    $signup_bonus = $settings->refer_bonus;
                }

                }

                $name = $request->name;
                $currentUserInfo = Location::get($this->gip($request));

                $token = md5(time().'.'.md5($request->uid));
                 $register_user = DB::insert('insert into users (uid,api_token,refer_id,ip,points,name,email,profile,device,join_time,country,login_type)
                 values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                 [$request->uid,$token,$randomString,$ip,$signup_bonus,$name, $request->email,$request->profile,$request->device,time(),$currentUserInfo->countryCode,$request->login_type]);

                if($isRefer){
                 $user = User::Where('api_token',$token)->first();
                 $add_track = new trackers;
                 $add_track->uid = $user->id;
                 $add_track->trans_from = 'Referral join bonus';
                 $add_track->type = 0;
                 $add_track->ip = $ip;
                 $add_track->amount = $settings->refer_bonus;
                 $add_track->extra = $r_id;
                 $add_track->time = time();

                 $add_track->save();
                }



                if($register_user){
                    return response()->json([
                        'error'=>'false',
                        'token'=>$token,
                    ]);
                }else{
                    return response()->json([
                        'error'=>'true',
                        'message'=>'Given data is wrong!',
                    ]);
                }
            }

    }
    public function addReferCodeCoins(Request $request){
        if(User::Where('refer_id',$request->code)->Where('status',0)->exists()){
            
            $r_user = User::Where('refer_id',$request->code)->first();
            $user = User::Where('api_token',$request->token)->first();
            $settings = DB::table('settings')->select('refer_bonus','refer_points')->first();
            $ip = $request->ip();
            
             if(!empty($r_user)){
                $r_id = $r_user->id;
                $isRefer = true;
                
                if(!empty($user->refer_by)){
                    return response()->json([
                        'error'=>'true',
                        'message'=>'Referral bonus has already been claimed.',
                    ]);
                }
    
                $r_user->points += $settings->refer_points;
                $user->points += $settings->refer_bonus;
                $user->refer_by = $request->code;
                $r_user->t_ref += 1;

                $add_track = new trackers;
                $add_track->uid = $r_user->id;
                $add_track->trans_from = 'Referral bonus';
                $add_track->type = 0;
                $add_track->ip = $ip;
                $add_track->amount = $settings->refer_points;
                $add_track->extra = $user->uid;
                $add_track->time = time();
                
                $signup_bonus = $settings->refer_bonus;

                
                 $add_track_ = new trackers;
                 $add_track_->uid = $user->id;
                 $add_track_->trans_from = 'Referral join bonus';
                 $add_track_->type = 0;
                 $add_track_->ip = $ip;
                 $add_track_->amount = $settings->refer_bonus;
                 $add_track_->extra = $r_id;
                 $add_track_->time = time();
                
    
                $r_user->save();
                $add_track->save();
                $add_track_->save();
                $user->save();
                
                
                if(!empty($user->refer_by)){
                    return response()->json([
                        'error'=>'false',
                        'message'=>$signup_bonus.' Coins Added.',
                    ]);
                }
                
                
                
            }

        }else{
                return response()->json([
                    'error'=>'false',
                    'message'=>'Invalid refer code!',
                ]);
        }
        
    }
    
    
    
        public function ads(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->exists()) {
        $ads = ad_setting::Where('type',0)->get();
        $settings = DB::table('settings')->select('spin_ad','scratch_ad','back_ad','spin_ad_int','scratch_ad_int','back_ad_int')->first();
        $array = array();

            foreach($ads as $ad){
                $ids = json_decode($ad->ids);
                $index[$ad->net_id] = $ids;
                
                array_push($array,$index);
                $index = null;
            }
            
            return response()->json([
                'error'=>'false',
                'data'=>$array,
                'spin_ad'=>$settings->spin_ad,
                'scratch_ad'=>$settings->scratch_ad,
                'back_ad'=>$settings->back_ad,
                'spin_ad_int'=>$settings->spin_ad_int,
                'scratch_ad_int'=>$settings->scratch_ad_int,
                'back_ad_int'=>$settings->back_ad_int,
            ]);
        }
    }
    
    
    

    public function trans(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->exists()) {
            $user = DB::table('users')->select('id')->where('api_token',$request->token)->first();
            $trans = trackers::Where('uid',$user->id)->orderBy('time','DESC')->get();

            if(empty($trans)){
                return response()->json([
                    'error'=>'true',
                    'message'=>'No Transactions!',
                ]);
            }

            $array = array();

            foreach($trans as $tran){
                $index['from'] = $tran->trans_from;
                $index['date'] =  $date = date("Y-m-d",$tran->time);
                $index['type'] = $tran->type;
                $index['amount'] = $tran->amount;

                array_push($array,$index);
            }

            return response()->json([
                'error'=>'false',
                'data'=>$array,
            ]);
        }else
        {
            return response()->json([
                'error'=>'true',
                'message'=>'No Transactions!',
            ]);
        }


    }

    public function add_points(Request $request)
    {
         if (DB::table('users')->where('api_token', $request->token)->exists()) {
             if($request->from=='Spin Reward'){

                    $date = date("Y-m-d");
                    $settings = DB::table('settings')->select('daily_spin')->first();
                    $left = trackers::Where('uid',$request->id)->Where('created_at','>',$date)->Where('trans_from','Spin Reward')->count();

                    if($left>=$settings->daily_spin){
                    return response()->json([
                        'null'=>'null',
                    ]);
                    }
                 

                    if($left>=$settings->daily_spin){
                    return response()->json([
                        'error'=>'true',
                    ]);
                    }
             }

            if($request->from=='Game Reward'){
                $game = games::find($request->extra);
                $game->plays+=1;
                $game->save();
            }
            

            
            if($request->from=='Scratch Reward'){
                    $date = date("Y-m-d");
                    $settings = DB::table('settings')->select('daily_scratch')->first();
                    $left = trackers::Where('uid',$request->id)->Where('created_at','>',$date)->Where('trans_from','Scratch Reward')->count();

                    if($left>=$settings->daily_scratch){
                    return response()->json([
                        'error'=>'true',
                    ]);
                    }
            }
            
            if($request->from=='Video Reward'){
                    $date = date("Y-m-d");
                    $settings_ad = DB::table('ad_settings')->select('ids')->where('id',$request->extra)->first();
                    $video = json_decode($settings_ad->ids);
                    $left = trackers::Where('uid',$request->id)->Where('created_at','>',$date)->Where('trans_from','Video Reward')->Where('extra',$request->extra)->count();

                    if($left>=$video->video_limit){
                    return response()->json([
                        'error'=>'true',
                    ]);
                    }
            }
            
            if($request->from=='Daily Reward'){
                $daily_coin = 0;
                $settings = DB::table('settings')->select('days')->first();
                $daily = json_decode($settings->days);
            
                $daily_coin = $daily->day_1;
                
                if($daily->day_2>$daily_coin){
                    $daily_coin = $daily->day_2;
                }
                 if($daily->day_3>$daily_coin){
                    $daily_coin = $daily->day_3;
                }
                if($daily->day_4>$daily_coin){
                    $daily_coin = $daily->day_4;
                }
                if($daily->day_5>$daily_coin){
                    $daily_coin = $daily->day_5;
                }
                if($daily->day_6>$daily_coin){
                    $daily_coin = $daily->day_6;
                }
               if($daily->day_7>$daily_coin){
                    $daily_coin = $daily->day_7;
                }
                
                    if($request->coins>$daily_coin){
                        $user = User::Where('api_token',$request->token)->first();
                        $user->status = 1;
                        $user->save();
                        
                    return response()->json([
                        'null'=>'null',
                    ]);
                    }
                
                
                

            }

                $user = User::Where('api_token',$request->token)->first();
                $user->points+= $request->coins;
                $xp = $request->coins*2;
                $user->xp+= $xp;
                $user->save();
                $date = date("Y-m-d");
                $add_track = new trackers;
                if(!empty($request->extra)){
                    $add_track->extra = $request->extra;
                }
                $add_track->uid = $user->id;
                $add_track->trans_from = $request->from;
                $add_track->type = 0;
                $add_track->amount = $request->coins;
                $add_track->time = time();
                $add_track->ip = $this->gip($request);
                $add_track->day = $date;
                $user->save();
                $add_track->save();

                return response()->json([
                    'error'=>'false',
                    'message'=>'+'.$request->coins.' Coins',
                ]);

        }


    }



    public function check_spin(Request $request)
    {
         if (DB::table('users')->where('api_token', $request->token)->exists()) {

              $date = date("Y-m-d");
                $settings = DB::table('settings')->select('daily_spin')->first();
                $left = trackers::Where('uid',$request->id)->Where('created_at','>',$date)->Where('trans_from','Spin Reward')->count();

                return response()->json([
                    'error'=>'false',
                    'left'=>$left,
                    'daily'=> $settings->daily_spin,
                    'time'=> strtotime('tomorrow') - time(),
                ]);

        }


    }

        public function check_scratch(Request $request)
    {
         if (DB::table('users')->where('api_token', $request->token)->exists()) {

              $date = date("Y-m-d");
                $settings = DB::table('settings')->select('daily_scratch','scratch_coins')->first();
                $left = trackers::Where('uid',$request->id)->Where('created_at','>',$date)->Where('trans_from','Scratch Reward')->count();

                return response()->json([
                    'error'=>'false',
                    'left'=>$left,
                    'daily'=> $settings->daily_scratch,
                    'min'=> $this->getMin($settings->scratch_coins),
                    'max'=> $this->getMax($settings->scratch_coins),
                    'time'=> strtotime('tomorrow') - time(),
                ]);

        }


    }

            public function noti(Request $request)
    {
         if (DB::table('users')->where('api_token', $request->token)->exists()) {

                $date = date("Y-m-d");
                $announce = announce::orderBy('id','DESC')->get();

                return response()->json([
                    'error'=>'false',
                    'data'=>$announce,

                ]);

        }


    }


        public function daily(Request $request)
    {
         if (DB::table('users')->where('api_token', $request->token)->exists()) {

                $date = date("Y-m-d");
                $settings = DB::table('settings')->select('days')->first();
                $left = trackers::Where('uid',$request->id)->Where('created_at','>',$date)->Where('trans_from','Scratch Reward')->count();
                $rewards = json_decode($settings->days);
                $days_to_check = 0;
                //0 = claim, 1 = claimed, 2 = missed, 3 = not available
                $day_s_1 = 3; $day_s_2 = 3; $day_s_3 = 3; $day_s_4 = 3; $day_s_5 = 3; $day_s_6 = 3; $day_s_7 = 3;
                $reward_1 = $rewards->day_1;
                $reward_2 = $rewards->day_2;
                $reward_3 = $rewards->day_3;
                $reward_4 = $rewards->day_4;
                $reward_5 = $rewards->day_5;
                $reward_6 = $rewards->day_6;
                $reward_7 = $rewards->day_7;

                $day = date('D');

                if($day=="Mon"){$day="Monday"; $days_to_check = 0;}
                elseif($day=="Tue"){$day="Tuesday"; $days_to_check = 1;}
                elseif($day=="Wed"){$day="Wednesday"; $days_to_check = 2;}
                elseif($day=="Thu"){$day="Thursday"; $days_to_check = 3;}
                elseif($day=="Fri"){$day="Friday"; $days_to_check = 4;}
                elseif($day=="Sat") {$day="Saturday"; $days_to_check = 5;}
                elseif($day=="Sun") {$day="Sunday"; $days_to_check = 6;}

                $days = $days_to_check;

                for ($x = 0; $x <= $days_to_check; $x++){
                        $check_date = date("Y-m-d",strtotime("-$days days"));
                        $days = $days-1;
                        $isClaimed = trackers::Where('uid',$request->id)->Where('day',$check_date)->Where('trans_from','Daily Reward')->count();
                        if($x == 0){
                            if($isClaimed>0){$day_s_1 = 1;}else{$day_s_1 = 2; if($days_to_check==$x){$day_s_1 = 0;}}
                        }elseif($x == 1){
                            if($isClaimed>0){$day_s_2 = 1;}else{$day_s_2 = 2; if($days_to_check==$x){$day_s_2 = 0;}}
                        }elseif($x == 2){
                            if($isClaimed>0){$day_s_3 = 1;}else{$day_s_3 = 2; if($days_to_check==$x){$day_s_3 = 0;}}
                        }elseif($x == 3){
                            if($isClaimed>0){$day_s_4 = 1;}else{$day_s_4 = 2; if($days_to_check==$x){$day_s_4 = 0;}}
                        }elseif($x == 4){
                            if($isClaimed>0){$day_s_5 = 1;}else{$day_s_5 = 2; if($days_to_check==$x){$day_s_5 = 0;}}
                        }elseif($x == 5){
                            if($isClaimed>0){$day_s_6 = 1;}else{$day_s_6 = 2; if($days_to_check==$x){$day_s_6 = 0;}}
                        }elseif($x == 6){
                            if($isClaimed>0){$day_s_7 = 1;}else{$day_s_7 = 2; if($days_to_check==$x){$day_s_7 = 0;}}
                        }

                        $isClaimed = null;

                }

                $user = DB::table('users')->select('id')->where('api_token',$request->token)->first();
                $visits = daily_task::orderBy('days','ASC')->get();

            $array = array();
            $date = date("Y-m-d");
            foreach($visits as $visit){

                $index['id'] = $visit->id;
                $index['days'] = $visit->days;
                $index['coins'] = $visit->coins;

               if(trackers::Where('uid',$user->id)->Where('trans_from','Daily Login Reward')->Where('extra',$visit->id)->exists()){
                   $index['status'] = true;
                }else{
                    $index['status'] = false;
                }
                array_push($array,$index);
            }

                return response()->json([
                    'error'=>'false',
                    'day_s_1'=>$day_s_1,
                    'day_s_2'=>$day_s_2,
                    'day_s_3'=>$day_s_3,
                    'day_s_4'=>$day_s_4,
                    'day_s_5'=>$day_s_5,
                    'day_s_6'=>$day_s_6,
                    'day_s_7'=>$day_s_7,
                    'reward_1'=>$reward_1,
                    'reward_2'=>$reward_2,
                    'reward_3'=>$reward_3,
                    'reward_4'=>$reward_4,
                    'reward_5'=>$reward_5,
                    'reward_6'=>$reward_6,
                    'reward_7'=>$reward_7,
                    'total_days'=>trackers::Where('uid',$user->id)->Where('trans_from','Daily Reward')->count(),
                    'data'=>$array,

                ]);

        }
    }


        public function games(Request $request)
    {
         if (DB::table('users')->where('api_token', $request->token)->exists()) {
                $games = games::orderBy('plays','DESC')->get();
                return response()->json([
                    'error'=>'false',
                    'data'=>$games,
                ]);

        }


    }
        public function home_data(Request $request)
    {
         if (DB::table('users')->where('api_token', $request->token)->exists()) {
                $games = games::limit(8)->orderBy('plays','DESC')->get();
                $banner = banner::orderBy('id','DESC')->get();
                return response()->json([
                    'error'=>'false',
                    'data'=>$games,
                    'banner'=>$banner,
                ]);

        }


    }


        public function visits(Request $request)
    {
         if (DB::table('users')->where('api_token', $request->token)->exists()) {
             $user = DB::table('users')->select('id')->where('api_token',$request->token)->first();
                $visits = visits::orderBy('id','DESC')->get();

            $array = array();
            $date = date("Y-m-d");
            foreach($visits as $visit){

                $index['id'] = $visit->id;
                $index['title'] = $visit->title;
                $index['link'] = $visit->link;
                $index['coins'] = $visit->coins;
                $index['time'] = $visit->time;
                if(trackers::Where('uid',$user->id)->Where('trans_from','Visit Reward')->Where('created_at','>',$date)->Where('extra',$visit->id)->exists()){
                   $index['status'] = true;
                }else{
                    $index['status'] = false;
                }
                array_push($array,$index);
            }


                return response()->json([
                    'error'=>'false',
                    'data'=>$array,
                ]);

        }


    }


            public function refer_task(Request $request)
    {
         if (DB::table('users')->where('api_token', $request->token)->exists()) {
             $user = DB::table('users')->select('id')->where('api_token',$request->token)->first();
             if(empty($request->type)){
                $visits = refer_task::limit(3)->orderBy('refers','ASC')->get();
             }else{
                $visits = refer_task::orderBy('refers','ASC')->get();
             }

            $array = array();
            $date = date("Y-m-d");
            $refers = trackers::Where('uid',$user->id)->Where('trans_from','Referral bonus')->count();
            foreach($visits as $visit){

                $index['id'] = $visit->id;
                $index['title'] = 'Invite '.$visit->refers.' friends';
                $index['refers'] = $visit->refers;
                $index['coins'] = $visit->coins;
                $index['total_ref'] = $refers;
                if(trackers::Where('uid',$user->id)->Where('trans_from','Referral Reward')->Where('extra',$visit->id)->exists()){
                   $index['status'] = 2; //claimed
                }else{
                    if($refers>=$visit->refers){
                        $index['status'] = 1; //claim
                    }else{
                      $index['status'] = 0;  //pending
                    }
                }
                array_push($array,$index);
            }


                return response()->json([
                    'error'=>'false',
                    'data'=>$array,
                ]);

        }


    }


        public function offers(Request $request)
    {
         if (DB::table('users')->where('api_token', $request->token)->exists()) {
             $user = DB::table('users')->select('id')->where('api_token',$request->token)->first();
                $ad_settings = ad_setting::orderBy('id','DESC')->Where('status',0)->Where('type',$request->type)->get();

        $array = array();
         $date = date("Y-m-d");


            foreach($ad_settings as $ad_setting){
                $ids = json_decode($ad_setting->ids);

                if($request->type==0){
                 if(trackers::Where('uid',$user->id)->Where('trans_from','Video Reward')->Where('created_at','>',$date)->Where('extra',$ad_setting->id)->count() >= $ids->video_limit) {
                    $index['status'] = false;
                }else{
                    $index['status'] = true;
                }

                }



                $index['id'] = $ad_setting->id;
                $index['name'] = $ad_setting->name;
                $index['image'] =  $ad_setting->image;
                $index['ids'] = $ids;
                $index['net_id'] = $ad_setting->net_id;

                array_push($array,$index);

            }

                return response()->json([
                    'error'=>'false',
                    'data'=>$array,
                ]);

        }


    }


    public function update_profile(Request $request){
         if (DB::table('users')->where('api_token', $request->token)->exists()) {
             $user = DB::table('users')->select('id')->where('api_token',$request->token)->first();
                $ad_settings = ad_setting::orderBy('id','DESC')->Where('status',0)->Where('type',$request->type)->get();

                $user = User::Where('api_token',$request->token)->first();
                $user->name = $request->name;
                $user->save();

                return response()->json([
                    'error'=>'false',
                    'message'=>'Profile Successfully Update!!',
                ]);

        }
    }

        public function bu(Request $request){
         if (DB::table('users')->where('api_token', $request->token)->exists()) {
             $user = DB::table('users')->select('id')->where('api_token',$request->token)->first();
                $ad_settings = ad_setting::orderBy('id','DESC')->Where('status',0)->Where('type',$request->type)->get();

                $user = User::Where('api_token',$request->token)->first();
                $user->status = 1;
                $user->save();

                return response()->json([
                    'error'=>'false',
                    'message'=>'Profile Successfully Update!!',
                ]);

        }
    }



    public function ApiOffers_off(Request $request)
    {

          if (DB::table('users')->where('api_token', $request->token)->where('uid', $request->uid)->exists()) {

            $settings = DB::table('settings')->select('fyberTest','app_id')->first();

            if($settings->fyberTest==0){
                //print_r($this->test_offer());
                $resp = $this->test_json();
                // return response()->json([
                //     'error'=>'false',
                //     'data'=>$this->test_json(),
                // ]);
            }else{
               $time = time();
               $clientIP = $request->ip();
                $fyber = "http://api.fyber.com/feed/v1/offers.json?";
                $url = "appid='$settings->app_id'
                &uid='$request->uid'&ip='$clientIP'&locale=EN
                &device_id='$request->uid'&timestamp='$time'";
                $hash = sha1($url);
                $api_url = $fyber.$url."&hashkey='$hash'";

               $curl = curl_init();
               curl_setopt_array($curl, array(
                   CURLOPT_URL => $url,// your preferred link
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_ENCODING => "",
                   CURLOPT_TIMEOUT => 30000,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "GET",
                   CURLOPT_HTTPHEADER => array(
                       // Set Here Your Requesred Headers
                       'Content-Type: application/json',
                   ),
            ));
               $resp = curl_exec($curl);
               $err = curl_error($curl);
               curl_close($curl);

               if ($err) {
                   echo "cURL Error #:" . $err;
               } else {
                   //print_r(json_decode($response));
                   return response()->json([
                    'error'=>'false',
                    'data'=>json_decode($resp),
                ]);
               }


           }
           $response = json_decode($resp);
           $offers = $response->offers;
           $data = array();
           foreach($offers as $offer) {
            $offer_datails['title'] = $offer->title;
            $offer_datails['offer_id'] = $offer->offer_id;
            $offer_datails['actions'] = $offer->required_actions;
            $thumbnail = $offer->thumbnail;
            if($thumbnail->hires!=null){
                $offer_datails['icon'] = $thumbnail->hires;
            }elseif($thumbnail->lowres!=null){
                $offer_datails['icon'] = $thumbnail->lowres;
            }

            if(offers::Where('offer_id',$offer->offer_id)->exists()){

                $db_offer = offers::select('offer_banner','rate')->Where('offer_id',$offer->offer_id)->first();
                if($db_offer->offer_banner!=0){
                    $offer_datails['banner'] = $db_offer->offer_banner;
                }

                if($db_offer->rate!=0){
                    $offer_datails['rate'] = $db_offer->rate;
                }

                $db_offer = null;
            }

            if(offer_status::Where('uid',$request->uid)->Where('offer_id',$offer->offer_id)->exists()){
                $get_status = offer_status::Where('uid',$request->uid)->Where('offer_id',$offer->offer_id)->first();
                $offer_datails['offer_status'] = $get_status->status;
            }

            $offer_types = $offer->offer_types;
            $offer_type = 0;

            foreach($offer_types as $type){
                if($type->offer_type_id==101){
                    $offer_type = "Easy";
                }elseif($type->offer_type_id==112){
                    $offer_type = "Easy";
                }elseif($type->offer_type_id==100){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==102){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==104){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==105){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==108){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==110){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==111){
                    $offer_type = "Hard";
                }elseif($type->offer_type_id==113){
                    $offer_type = "Hard";
                }elseif($type->offer_type_id==114){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==106){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==107){
                    $offer_type = "Hard";
                }elseif($type->offer_type_id==109){
                    $offer_type = "Hard";
                }elseif($type->offer_type_id==103){
                    $offer_type = "Hard";
                }

            }

            $offer_datails['type'] = $offer_type;
            $time_to_payout = $offer->time_to_payout;
            $offer_datails['amount'] = $time_to_payout->amount;
            $offer_datails['steps'] = $offer->action_steps;
            $offer_datails['url'] = $offer->url;

            if(offer_lists::where('uid',$request->uid)->where('offer_id',$offer->offer_id)->exists()){
               $list = offer_lists::select('status')->where('uid',$request->uid)->where('offer_id',$offer->offer_id)->first();
               $offer_datails['offer_status'] = $list->status;
            }

            array_push($data,$offer_datails);
            $offer_datails = null;
           }

           return response()->json([
            'error'=>'false',
            'data'=>$data,
           ]);


          }else{
            return response()->json([
                'error'=>'true',
                'message'=>"error",
               ]);
          }


    }


    public function ApiOffers(Request $request)
    {

          if (DB::table('users')->where('api_token', $request->token)->where('uid', $request->uid)->exists()) {

            $settings = DB::table('settings')->select('fyberTest','app_id')->first();

            if($settings->fyberTest==0){
                //print_r($this->test_offer());
                $resp = $this->test_json();
                // return response()->json([
                //     'error'=>'false',
                //     'data'=>$this->test_json(),
                // ]);
            }else{
                $currentUserInfo = Location::get($this->gip($request));
                $app_id = '14611';
                $pub_id = '24120';
                $secretkey = '85fc9461c7f2b33f038ac385ff9ae27a';
                $time = time();
                $clientIP = $request->ip();
                 $fyber = "https://www.offertoro.com/api/?";
                 $url = "appid=$app_id&pubid=$pub_id&country=$currentUserInfo->countryCode&secretkey=$secretkey&platform=MOBILE&format=json";
                 $hash = sha1($url);
                 $api_url = $fyber.$url;

               $curl = curl_init();
               curl_setopt_array($curl, array(
                   CURLOPT_URL => $api_url,// your preferred link
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_ENCODING => "",
                   CURLOPT_TIMEOUT => 30000,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "GET",
                   CURLOPT_HTTPHEADER => array(
                       // Set Here Your Requesred Headers
                       'Content-Type: application/json',
                   ),
            ));
               $resp = curl_exec($curl);
               $err = curl_error($curl);
               curl_close($curl);

               if ($err) {
                   echo "cURL Error #:" . $err;
               } else {
                   //print_r(json_decode($response));
                //    return response()->json([
                //     'error'=>'false',
                //     'data'=>json_decode($resp),
                // ]);
               }


           }
           $response = json_decode($resp);
           //dd($response);
           $res = $response->response;
           $offers = $res->offers;
           $data = array();
           foreach($offers as $offer) {
            $offer_datails['title'] = $offer->offer_name;
            $offer_datails['offer_id'] = $offer->offer_id;
            $offer_datails['actions'] = $offer->call_to_action;


            $offer_datails['icon'] = $offer->image_url;

            if(offers::Where('offer_id',$offer->offer_id)->exists()){

                $db_offer = offers::select('offer_banner','rate')->Where('offer_id',$offer->offer_id)->first();
                if($db_offer->offer_banner!=0){
                    $offer_datails['banner'] = $db_offer->offer_banner;
                }

                if($db_offer->rate!=0){
                    $offer_datails['rate'] = $db_offer->rate;
                }

                $db_offer = null;
            }

            if(offer_status::Where('uid',$request->uid)->Where('offer_id',$offer->offer_id)->exists()){
                $get_status = offer_status::Where('uid',$request->uid)->Where('offer_id',$offer->offer_id)->first();
                $offer_datails['offer_status'] = $get_status->status;
            }

            $offer_type = 0;

                if($offer->amount<=5000){
                    $offer_type = "Easy";
                }elseif($offer->amount<=10000){
                    $offer_type = "Medium";
                }elseif($offer->amount<=20000){
                    $offer_type = "Hard";
                }else{
                    $offer_type = "Easy";
                }

            $steps = array();
            $step['step'] = $offer->call_to_action;
            array_push($steps,$step);
            $step2['step'] = $offer->disclaimer;
            array_push($steps,$step2);

            $offer_datails['type'] = $offer_type;
            $time_to_payout = $offer->disclaimer;
            $offer_datails['amount'] = $offer->amount;
            $offer_datails['steps'] = $steps;
            $offer_datails['url'] = $offer->offer_url_easy;

            if(offer_lists::where('uid',$request->uid)->where('offer_id',$offer->offer_id)->exists()){
               $list = offer_lists::select('status')->where('uid',$request->uid)->where('offer_id',$offer->offer_id)->first();
               $offer_datails['offer_status'] = $list->status;
            }

            array_push($data,$offer_datails);
            $offer_datails = null;
           }

           return response()->json([
            'error'=>'false',
            'data'=>$data,
           ]);


          }else{
            return response()->json([
                'error'=>'true',
                'message'=>"error",
               ]);
          }


    }


    public function in_ApiOffers(Request $request)
    {

          if (DB::table('users')->where('api_token', $request->token)->where('uid', $request->uid)->exists()) {

            $settings = DB::table('settings')->select('fyberTest','app_id')->first();

            if($settings->fyberTest==0){
                //print_r($this->test_offer());
                $resp = $this->test_json();
                // return response()->json([
                //     'error'=>'false',
                //     'data'=>$this->test_json(),
                // ]);
            }else{
                $currentUserInfo = Location::get($this->gip($request));
                $app_id = '14611';
                $pub_id = '24120';
                $secretkey = '85fc9461c7f2b33f038ac385ff9ae27a';
                $time = time();
                $clientIP = $request->ip();
                 $fyber = "https://www.offertoro.com/api/?";
                 $url = "appid=$app_id&pubid=$pub_id&country=$currentUserInfo->countryCode&secretkey=$secretkey&platform=MOBILE&format=json";
                 $hash = sha1($url);
                 $api_url = $fyber.$url;

               $curl = curl_init();
               curl_setopt_array($curl, array(
                   CURLOPT_URL => $api_url,// your preferred link
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_ENCODING => "",
                   CURLOPT_TIMEOUT => 30000,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "GET",
                   CURLOPT_HTTPHEADER => array(
                       // Set Here Your Requesred Headers
                       'Content-Type: application/json',
                   ),
            ));
               $resp = curl_exec($curl);
               $err = curl_error($curl);
               curl_close($curl);

               if ($err) {
                   echo "cURL Error #:" . $err;
               } else {
                   //print_r(json_decode($response));
                //    return response()->json([
                //     'error'=>'false',
                //     'data'=>json_decode($resp),
                // ]);
               }


           }
           $response = json_decode($resp);
           //dd($response);
           $res = $response->response;
           $offers = $res->offers;
           $data = array();
           foreach($offers as $offer) {
            if(offer_status::Where('uid',$request->uid)->Where('offer_id',$offer->offer_id)->exists()){
                $get_status = offer_status::Where('uid',$request->uid)->Where('offer_id',$offer->offer_id)->first();
                $offer_datails['offer_status'] = $get_status->status;

                $offer_datails['title'] = $offer->offer_name;
                $offer_datails['offer_id'] = $offer->offer_id;
                $offer_datails['actions'] = $offer->call_to_action;


                $offer_datails['icon'] = $offer->image_url;

                if(offers::Where('offer_id',$offer->offer_id)->exists()){

                    $db_offer = offers::select('offer_banner','rate')->Where('offer_id',$offer->offer_id)->first();
                    if($db_offer->offer_banner!=0){
                        $offer_datails['banner'] = $db_offer->offer_banner;
                    }

                    if($db_offer->rate!=0){
                        $offer_datails['rate'] = $db_offer->rate;
                    }

                    $db_offer = null;
                }

                if(offer_status::Where('uid',$request->uid)->Where('offer_id',$offer->offer_id)->exists()){
                    $get_status = offer_status::Where('uid',$request->uid)->Where('offer_id',$offer->offer_id)->first();
                    $offer_datails['offer_status'] = $get_status->status;
                }

                $offer_type = 0;

                    if($offer->amount<=5000){
                        $offer_type = "Easy";
                    }elseif($offer->amount<=10000){
                        $offer_type = "Medium";
                    }elseif($offer->amount<=20000){
                        $offer_type = "Hard";
                    }else{
                        $offer_type = "Easy";
                    }

                $steps = array();
                $step['step'] = $offer->call_to_action;
                array_push($steps,$step);
                $step2['step'] = $offer->disclaimer;
                array_push($steps,$step2);

                $offer_datails['type'] = $offer_type;
                $time_to_payout = $offer->disclaimer;
                $offer_datails['amount'] = $offer->amount;
                $offer_datails['steps'] = $steps;
                $offer_datails['url'] = $offer->offer_url_easy;

                if(offer_lists::where('uid',$request->uid)->where('offer_id',$offer->offer_id)->exists()){
                   $list = offer_lists::select('status')->where('uid',$request->uid)->where('offer_id',$offer->offer_id)->first();
                   $offer_datails['offer_status'] = $list->status;
                }
            array_push($data,$offer_datails);
            $offer_datails = null;
        }
           }

           return response()->json([
            'error'=>'false',
            'data'=>$data,
           ]);


          }else{
            return response()->json([
                'error'=>'true',
                'message'=>"error",
               ]);
          }


    }


    public function in_ApiOffers_off(Request $request)
    {

          if (DB::table('users')->where('api_token', $request->token)->where('uid', $request->uid)->exists()) {

            $settings = DB::table('settings')->select('fyberTest','app_id')->first();

            if($settings->fyberTest==0){
                //print_r($this->test_offer());
                $resp = $this->test_json();
                // return response()->json([
                //     'error'=>'false',
                //     'data'=>$this->test_json(),
                // ]);
            }else{
                $time = time();
                $clientIP = $request->ip();
                $fyber = "http://api.fyber.com/feed/v1/offers.json?";
                $url = "appid='$settings->app_id'
                &uid='$request->uid'&ip='$clientIP'&locale=EN
                &device_id='$request->uid'&timestamp='$time'";
                $hash = sha1($url);
                $api_url = $fyber.$url."&hashkey='$hash'";

               $curl = curl_init();
               curl_setopt_array($curl, array(
                   CURLOPT_URL => $url,// your preferred link
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_ENCODING => "",
                   CURLOPT_TIMEOUT => 30000,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "GET",
                   CURLOPT_HTTPHEADER => array(
                       // Set Here Your Requesred Headers
                       'Content-Type: application/json',
                   ),
            ));
               $resp = curl_exec($curl);
               $err = curl_error($curl);
               curl_close($curl);

               if ($err) {
                   echo "cURL Error #:" . $err;
               } else {
                   //print_r(json_decode($response));
                   return response()->json([
                    'error'=>'false',
                    'data'=>json_decode($resp),
                ]);
               }


           }
           $response = json_decode($resp);
           $offers = $response->offers;
           $data = array();
           foreach($offers as $offer) {
            if(offer_status::Where('uid',$request->uid)->Where('offer_id',$offer->offer_id)->exists()){
                $get_status = offer_status::Where('uid',$request->uid)->Where('offer_id',$offer->offer_id)->first();
                $offer_datails['offer_status'] = $get_status->status;

            $offer_datails['title'] = $offer->title;
            $offer_datails['offer_id'] = $offer->offer_id;
            $offer_datails['actions'] = $offer->required_actions;
            $thumbnail = $offer->thumbnail;
            if($thumbnail->hires!=null){
                $offer_datails['icon'] = $thumbnail->hires;
            }elseif($thumbnail->lowres!=null){
                $offer_datails['icon'] = $thumbnail->lowres;
            }

            if(offers::Where('offer_id',$offer->offer_id)->exists()){

                $db_offer = offers::select('offer_banner','rate')->Where('offer_id',$offer->offer_id)->first();
                if($db_offer->offer_banner!=0){
                    $offer_datails['banner'] = $db_offer->offer_banner;
                }

                if($db_offer->rate!=0){
                    $offer_datails['rate'] = $db_offer->rate;
                }

                $db_offer = null;
            }

            $offer_types = $offer->offer_types;
            $offer_type = 0;

            foreach($offer_types as $type){
                if($type->offer_type_id==101){
                    $offer_type = "Easy";
                }elseif($type->offer_type_id==112){
                    $offer_type = "Easy";
                }elseif($type->offer_type_id==100){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==102){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==104){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==105){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==108){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==110){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==111){
                    $offer_type = "Hard";
                }elseif($type->offer_type_id==113){
                    $offer_type = "Hard";
                }elseif($type->offer_type_id==114){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==106){
                    $offer_type = "Medium";
                }elseif($type->offer_type_id==107){
                    $offer_type = "Hard";
                }elseif($type->offer_type_id==109){
                    $offer_type = "Hard";
                }elseif($type->offer_type_id==103){
                    $offer_type = "Hard";
                }

            }

            $offer_datails['type'] = $offer_type;
            $time_to_payout = $offer->time_to_payout;
            $offer_datails['amount'] = $time_to_payout->amount;
            $offer_datails['steps'] = $offer->action_steps;
            $offer_datails['url'] = $offer->url;

            if(offer_lists::where('uid',$request->uid)->where('offer_id',$offer->offer_id)->exists()){
               $list = offer_lists::select('status')->where('uid',$request->uid)->where('offer_id',$offer->offer_id)->first();
               $offer_datails['offer_status'] = $list->status;
            }

            array_push($data,$offer_datails);
            $offer_datails = null;
        }
           }

           return response()->json([
            'error'=>'false',
            'data'=>$data,
           ]);


          }else{
            return response()->json([
                'error'=>'true',
                'message'=>"error",
               ]);
          }


    }



    public function refer(Request $r){
        $settings = DB::table('settings')->select('package_name')->first();
        if(User::Where('refer_id',$r->refer_id)->Where('status','0')->exists()){
            $r_data = new refer_datas;
            $r_data->ip = $this->gip($r);
            $r_data->refer_id = $r->refer_id;
            $r_data->time = time()+60*15;
            $r_data->save();
            return redirect('https://play.google.com/store/apps/details?id='.$settings->package_name);
        }
        return redirect('https://play.google.com/store/apps/details?id='.$settings->package_name);
    }

    public function reward(Request $r){
                        return response()->json([
                'error'=>'false',

               ]);
        if (User::Where('api_token',$r->token)->exists()) {
            $settings = DB::table('settings')->select('paypal_coins','paypal_amount','btc_coins','btc_amount','eth_coins','eth_amount')->first();
            return response()->json([
                'error'=>'false',
                'paypal_coins'=>$settings->paypal_coins,
                'paypal_amount'=>$settings->paypal_amount,
                'btc_coins'=>$settings->btc_coins,
                'btc_amount'=>$settings->btc_amount,
                'eth_coins'=>$settings->eth_coins,
                'eth_amount'=>$settings->eth_amount,
               ]);
        }else{

        }
    }

    public function redeem(Request $r){


        if (User::Where('api_token',$r->token)->Where('uid',$r->uid)->exists()) {

            $settings = DB::table('settings')->select('paypal_coins','paypal_amount','btc_coins','btc_amount','eth_coins','eth_amount')->first();
            $user = User::Where('api_token',$r->token)->Where('uid',$r->uid)->first();
            $type = $r->type;
            $email = $r->email;
            $wallet = $r->wallet;
            switch($type){
                case 1:
                    $name = 'Paypal';
                    $amount = $settings->paypal_amount;
                    $coins = $settings->paypal_coins;
                    $wallet = 0;
                    break;
                case 2:
                    $name = 'BTC';
                    $amount = $settings->btc_amount;
                    $coins = $settings->btc_coins;
                    break;
                case 3:
                    $name = 'ETH';
                    $amount = $settings->eth_amount;
                    $coins = $settings->eth_coins;
                    break;
            }

            if($user->points>=$coins){
                $user->points -= $coins;
                $add_track = new trackers;
                $add_track->uid = $user->id;
                $add_track->trans_from = $name.' redeem';
                $add_track->type = 1;
                $add_track->ip = $this->gip($r);
                $add_track->amount = $coins;
                $add_track->extra = $user->uid;
                $add_track->time = time();

                $redeem = new redeems;
                $redeem->uid = $user->id;
                $redeem->redeem_name = $name;
                $redeem->amount = $amount;
                $redeem->coins_used = $coins;
                $redeem->email = $email;
                $redeem->wallet_address = $wallet;

                $redeem->save();
                $user->save();
                $add_track->save();

                return response()->json([
                    'error'=>'false',
                    'message'=>'Your redeem successfully submitted.',
                   ]);

            }else{
                return response()->json([
                    'error'=>'false',
                    'message'=>'Need '.$coins-$user->points.' coins to reeem.',
                   ]);
            }


        }
    }

    public function daily_bonus(Request $r){

        if (User::Where('api_token',$r->token)->Where('uid',$r->uid)->exists()) {
            $settings = DB::table('settings')->select('daily_bonus')->first();
            $user = User::Where('api_token',$r->token)->first();
            $track = trackers::Where('uid',$user->id)->Where('trans_from','Daily bonus')->orderBy('time','DESC')->first();
            if(empty($track)){
                $user->points += $settings->daily_bonus;
                $add_track = new trackers;
                $add_track->uid = $user->id;
                $add_track->trans_from = 'Daily bonus';
                $add_track->type = 0;
                $add_track->amount = $settings->daily_bonus;
                $add_track->extra = $r->uid;
                $add_track->time = time();
                $add_track->ip = $this->gip($r);
                $user->save();
                $add_track->save();
                return response()->json([
                    'error'=>'false',
                    'message'=>$settings->daily_bonus,
                    'type'=>'Daily bonus allready claimed !!',
                   ]);
            }
            //dd(date('Y-m-d', 1683103176));
            $date = date("Y-m-d",$track->time);
            $today = date("Y-m-d");
            if($today!=$date){
                $user->points += $settings->daily_bonus;
                $add_track = new trackers;
                $add_track->uid = $user->id;
                $add_track->trans_from = 'Daily bonus';
                $add_track->type = 0;
                $add_track->amount = $settings->daily_bonus;
                $add_track->extra = $r->uid;
                $add_track->time = time();
                $add_track->ip = $this->gip($r);
                $user->save();
                $add_track->save();

                return response()->json([
                    'error'=>'false',
                    'message'=>$settings->daily_bonus,
                    'type'=>'Daily bonus allready claimed !!',
                   ]);

            }else{
                return response()->json([
                    'error'=>'false',
                    'message'=>'Daily bonus allready claimed !!',

                   ]);
            }
        }else{
            return response()->json([
                'error'=>'false',
                'message'=>'Daily bonus allready claimed !!.',
               ]);
        }

    }

    public function start_offer(Request $r){
        if (User::Where('api_token',$r->token)->Where('uid',$r->uid)->exists()) {
            $settings = DB::table('settings')->select('daily_bonus')->first();
            $user = User::Where('api_token',$r->token)->first();

            $currentUserInfo = Location::get($this->gip($r));


            if(!offers::Where('offer_id',$r->offer_id)->exists()){
                $offer = new offers;
                $offer->title = $r->title;
                $offer->description = $r->desc;
                $offer->offer_id = $r->offer_id;
                $offer->offer_image = $r->image;
                $offer->coins = $r->amount;
                $offer->country = $currentUserInfo->countryCode;
                $offer->save();
            }else{
                $offer = offers::Where('offer_id',$r->offer_id)->first();
                $offer->click +=1;
                $offer->save();
            }

            if(offer_status::Where('uid',$r->uid)->Where('offer_id',$r->offer_id)->exists()){
                return response()->json([
                    'error'=>'false',
                   ]);
            }else{
                $add_offer = new offer_status;
                $add_offer->uid = $r->uid;
                $add_offer->offer_id = $r->offer_id;
                $add_offer->save();
                return response()->json([
                    'error'=>'false',
                   ]);
            }

        }

    }

    public function reward_(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->exists()) {

            $rewards = rewards::Where('status',0)->get();
            $array = array();

            $min_amount = reward_amounts::orderBy('coins', 'ASC')->first();

            foreach($rewards as $reward){
                 $index['id'] = $reward->id;
                 $index['name'] = $reward->name;
                 $index['image'] = $reward->image;
                 $index['symbol'] = $reward->symbol;
                 $index['hint'] = $reward->hint;
                 $index['input_type'] = $reward->input_type;
                 $index['details'] = $reward->details;
                $reward_amounts = reward_amounts::Where('r_id',$reward->id)->orderBy('coins', 'ASC')->get();
                $is_first = true;

                foreach($reward_amounts as $amount){
                    if($is_first){
                        $index['minimum'] = $amount->coins;
                        $is_first = false;

                    }
                }

                if(!$is_first){
                    $index['amounts'] = $reward_amounts;
                    array_push($array,$index);
                }
            }

            return response()->json([
                'error'=>'false',
                'data'=>$array,
                'min'=>$min_amount->coins,
            ]);
        }
    }

    public function redeem_(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->exists()) {
            if(rewards::Where('id',$request->redeem)->Where('status',0)->exists() && reward_amounts::Where('id',$request->amount_id)->Where('r_id',$request->redeem)->exists()){
                $user = User::Where('api_token',$request->token)->first();
                $amount = reward_amounts::Where('id',$request->amount_id)->Where('r_id',$request->redeem)->first();
                if($user->points>=$amount->coins){
                    $user->points-=$amount->coins;
                    $r = rewards::Where('id',$request->redeem)->Where('status',0)->first();
                    $rewards = new reward_lists;
                    $rewards->u_id = $user->id;
                    $rewards->package_name = $r->name;
                    $rewards->p_details = $request->p_details;
                    $rewards->coins_used = $amount->coins;
                    $rewards->symbol = $r->symbol;
                    $rewards->amount = $amount->amount;
                    $rewards->date = date("Y-m-d");
                    $rewards->time = time();
                    $rewards->status =0;
                    $rewards->package_id = $r->id;

                    $add_track = new trackers;
                    $add_track->uid = $user->id;
                    $add_track->trans_from = $r->name.' redeem';
                    $add_track->type = 1;
                    $add_track->ip = $request->ip();
                    $add_track->amount = $amount->coins;
                    $add_track->extra = $r->id;
                    $add_track->time = time();
                    $user->save();
                    $rewards->save();
                    $add_track->save();

                    return response()->json([
                        'error'=>'false',
                        'message'=>'Request for '.$r->name.' sent successfully',
                    ]);

                }else{
                    return response()->json([
                        'error'=>'false',
                        'message'=>'Not enough points available to redeem',
                    ]);
                }
            }

        }
    }

    public function user_h(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->exists()) {
            $user = User::Where('api_token',$request->token)->first();
            $redeem = reward_lists::join('rewards','rewards.id','=','reward_lists.package_id')
            ->select('rewards.image','reward_lists.*')
            ->where('u_id',$user->id)->orderBy('id', 'DESC')->get();
            return response()->json([
                'error'=>'false',
                'data'=>$redeem,
            ]);
        }
    }

    public function leaders(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->exists()) {
                $leaders = User::limit(50)->orderBy('points', 'DESC')->get();
                $array = array();
                $rank = 0;
                $user = User::Where('api_token',$request->token)->first();
                foreach($leaders as $leader){
                    $rank++;
                        $index['rank'] = $rank;
                        $index['coins'] = $leader->points;
                        $index['name'] = $leader->name;
                        $level = $leader->xp/500;
                        $level = (int)$level;
                        $index['level'] = $level;
                        $index['profile'] = $leader->profile;
                        
                        
                        $level = $leader->xp/500;
                        $index['level'] = (int)$level;
                        $lvlProgress=$leader->xp-$level*500;
                        $xpNeed = 500;
                        
                        if($level>=5){
                            $xp=$leader->xp-500*5;
                            $level2 =$xp/1000;
                            $level2 = (int)$level2;
                            $lvlProgress=$xp-$level2*1000;
                            $xpNeed = 1000;
                            $index['level'] = $level2+=5;
                            
                                    
                        if($level2>=10){
                            $xp_ = 500*5;
                            $xp_2 = 1000*5;
                            $xp__ = $xp_ + $xp_2;
                            $xp2=$leader->xp-$xp__;
                            $level3 =$xp2/2000;
                            $level3 = (int)$level3;
                            $lvlProgress=$xp2-$level3*2000;
                            $xpNeed = 2000;
                            $level = $level3+=10;
                            
                        }
                        }
                        
                        
                        
                        
                        array_push($array,$index);

                }
                return response()->json([
                    'error'=>'false',
                    'data'=>$array,
                ]);

        }
    }
    
    public function up_pro(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->exists()) {
                $user = User::Where('api_token',$request->token)->first();
                $avatar = base64_decode($request->img);
                $filename = time() . '.png';
                Image::make($avatar)->fit(120, 120)->save('images/avatar/'.$filename);
                $avatarPath = '/images/avatar/'.$filename;
                $user->profile = url('/images/avatar/'.$filename);
                $user->save();
                
                return response()->json([
                    'error'=>'false',
                ]);

        }
    }
    

    public function add(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->exists()) {
                $user = User::Where('api_token',$request->token)->first();
                $user->points+= $request->coins;
                $user->save();
                return response()->json([
                    'error'=>'false',
                ]);

        }
    }

    public function deduct(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->exists()) {
                $user = User::Where('api_token',$request->token)->first();
                $user->points-= $request->coins;
                $user->save();
                return response()->json([
                    'error'=>'false',
                ]);

        }
    }
    
        public function delete(Request $request)
    {
        if (DB::table('users')->where('api_token', $request->token)->exists()) {
                $user = User::Where('api_token',$request->token)->first();
                trackers::where('uid',$user->id)->delete();
                reward_lists::where('u_id',$user->id)->delete();
                User::Where('api_token',$request->token)->delete();
                return response()->json([
                    'error'=>'false',
                ]);

        }
    }


    public function gip($r){
       return $r->ip();
       //return '103.175.8.244';
    }


    public function btc(){
        $currency = 'USD';
        $url = 'https://bitpay.com/api/rates/'.$currency;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result= curl_exec ($ch);
        curl_close ($ch);
        $info = json_decode($result, true);
        echo "<pre>";
        dd($info);
     }
  public function getMax($string){
    $data = $string;
    $value = substr($data, strpos($data, "-") + 1);
    return $value;
  }
  public function getMin($string){
    $mystring = $string;
    $value = strtok($mystring, '-');
    return $value;
  }
  
    
    public function test__(){
        $params = [];
        $params['headings'] = [ "en"=>"Earn Rewards with SuperPaisa" ];
        $message = "Redeem reward now";
        OneSignal::sendNotificationToExternalUser($message,"274",null,null,null,null,"SuperPaisa",null);
        //sendNotificationToExternalUser($message, $userId, $url = null, $data = null, $buttons = null, $schedule = null, $headings = null, $subtitle = null);

  }
  
    public function ag(Request $request){
        if (DB::table('users')->where('api_token', $request->token)->exists()) {
         //api offer code start
         $ad = ad_setting::Where('net_id','adget')->first();
         $ids = json_decode($ad->ids);
         if($ids->api_status != 0){
            return response()->json([
                'error'=>'true',
            ]);
         }
                $user = User::Where('api_token',$request->token)->first();
                $agent = \Request::header('User-Agent');
                //$currentUserInfo = Location::get($this->gip($request));
                $app_id = '14611';
                $pub_id = '24120';
                $secretkey = '85fc9461c7f2b33f038ac385ff9ae27a';
                $time = time();
                $clientIP = $request->ip();
                $api = "https://api.adgatemedia.com/v1/user-based-api/offers";
                $ip = $this->gip($request);
                $url = "?aff_id=$ids->aff_id&api_key=$ids->api_key&wall_code=$ids->AdGateMedia_Wallcode&user_id=$user->id&ip=$ip&user_agent=$agent&in_app=true&rank_method=cr&take=2";
                $api_url = str_replace ( ' ', '%20', $api.$url);

               $curl = curl_init();
               curl_setopt_array($curl, array(
                   CURLOPT_URL => $api_url,// your preferred link
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_ENCODING => "",
                   CURLOPT_TIMEOUT => 30000,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "GET",
                   CURLOPT_HTTPHEADER => array(
                       // Set Here Your Requesred Headers
                       'Content-Type: application/json',
                   ),
            ));
               $resp = curl_exec($curl);
               $err = curl_error($curl);
               curl_close($curl);

               if ($err) {
                   echo "cURL Error #:" . $err;
               } else {
                   //print_r(json_decode($response));
                //    return response()->json([
                //     'error'=>'false',
                //     'data'=>json_decode($resp),
                // ]);
               }

           $response = json_decode($resp);
          // dd($response->data);
           
           $offer_array = array();
           $count =0;
            foreach($response->data as $offer){
                $count++;
                if($count<200){
                $offer_['id'] = $offer->id;
                $offer_['title'] = $offer->anchor;
                $offer_['steps'] = $offer->things_to_know;
                $offer_['requirements'] = $offer->requirements;
                $offer_['desc'] = $offer->description;
                $offer_['click_url'] = $offer->click_url;
                $offer_['icon'] = $offer->icon_url;
                $offer_['coins'] = $offer->total_points;
                $offer_['time'] = $offer->confirmation_time;
                $offer_['events'] = $offer->events;
                $offer_['cats'] = "CPA";
                
                foreach($offer->categories as $cat){
                    if($cat=="Free" or $cat=="Android" or $cat=="CPA" or $cat=="CPI"){

                        if($cat=="Android"){
                             $offer_['cats'] = "Android";
                        }if($cat=="CPA"){
                             $offer_['cats'] = "CPA";
                        }if($cat=="CPI"){
                             $offer_['cats'] = "CPI";
                        }
                    }
                }
                
             
                
                array_push($offer_array,$offer_);
                }
            }
            
            return response()->json([
                'error'=>'false',
                'data'=>$offer_array,
            ]);
        }
           
    }
  
  
}
