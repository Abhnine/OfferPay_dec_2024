<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\trackers;
use App\Models\offer_status;
use DB;
class S2SController extends Controller
{
    public function adjoe(Request $r)
    {
        if (DB::table('users')->where('uid', $r->user_uuid)->exists()) {
            $sid = null;
            //sid = sha1(concatenate(trans_uuid, user_uuid, currency, coin_amount, device_id, sdk_app_id, s2s_token))
            $settings = DB::table('settings')->select('adjoe_s2s_toekn')->first();
            $sid = sha1($r->trans_uuid.$r->user_uuid.$r->currency.$r->coin_amount.$r->device_id.$r->sdk_app_id.$settings->adjoe_s2s_toekn);

            if($r->sid==$sid){
                //success
                $user = User::Where('uid',$r->user_uuid)->first();
                $user->points += $r->coin_amount;
                $add_track = new trackers;
                $add_track->uid = $user->id;
                $add_track->trans_from = 'Adjoe offer';
                $add_track->type = 0;
                $add_track->amount = $r->coin_amount;
                $add_track->extra = $user->uid;
                $add_track->time = time();
                $add_track->ip = $r->ip();
                $add_track->save();
                $user->save();

                return response()->json([
                    'error'=>'false',
                    'message'=>'success',
                   ]);

            }

        }
    }

    public function is(Request $r)
    {
        if (DB::table('users')->where('uid', $r->USER_ID)->exists()) {
            $sid = null;
            $settings = DB::table('settings')->select('IS_PRIVATE_KEY')->first();
            //$sid = md5($r->TIMESTAMP.$r->EVENTID.$r->USER_ID.$r->REWARDS.$settings->IS_PRIVATE_KEY);
                //success
                //?USER_ID=[USER_ID]&REWARDS=[REWARDS]&EVENT_ID=[EVENT_ID]
                $user = User::Where('id',$r->USER_ID)->first();
                $user->points += $r->REWARDS;
                $add_track = new trackers;
                $add_track->uid = $user->id;
                $add_track->trans_from = 'Ironsource offer';
                $add_track->type = 0;
                $add_track->amount = $r->REWARDS;
                $add_track->extra = $user->uid;
                $add_track->time = time();
                $add_track->ip = $r->ip();
                $add_track->save();
                $user->save();

                return response()->json([
                    'error'=>'false',
                    'message'=>'success',
                   ]);

        }
    }

    public function fyber(Request $r)
    {
        if($r->ip()=='52.51.229.163' or $r->ip()=='52.208.7.124' or $r->ip()=='52.212.4.99'){
            if (DB::table('users')->where('uid', $r->uid)->exists()) {
                $sid = null;
                $settings = DB::table('settings')->select('IS_PRIVATE_KEY')->first();
                //$sid = md5($r->TIMESTAMP.$r->EVENTID.$r->USER_ID.$r->REWARDS.$settings->IS_PRIVATE_KEY);
                    //success
                    $user = User::Where('id',$r->uid)->first();
                    $user->points += $r->amount;
                    $add_track = new trackers;
                    $add_track->uid = $user->id;
                    $add_track->trans_from = 'Fyber offer';
                    $add_track->type = 0;
                    $add_track->amount = $r->amount;
                    $add_track->extra = $user->uid;
                    $add_track->time = time();
                    $add_track->ip = $r->ip();
                    $add_track->save();
                    $user->save();
                    if(offer_status::Where('id',$r->uid)->Where('offer_id',$r->campaign_id)->exists()){
                        $add_offer = offer_status::Where('uid',$r->uid)->Where('offer_id',$r->lpid)->first();
                        $add_offer->status = 1;
                        $add_offer->save();
                        return response()->json([
                            'error'=>'false',
                           ]);
                    }
                    return response()->json(['success' => 'success'], 200);

            }else{
                return response()->json(['failed' => 'failed'], 301);
            }
        }
    }



    public function adgem(Request $r)
    {
        if (DB::table('users')->where('uid', $r->player_id)->exists()) {
            $settings = DB::table('settings')->select('ADGEM_POSTBACK_KEY')->first();
            $ADGEM_POSTBACK_KEY = $settings->ADGEM_POSTBACK_KEY;
                    // securely supply the static whitelist ip and your secret postback key using env variables
            // get the full request url
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
            $request_url = "$protocol://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            // parse the url and query string
            $parsed_url = parse_url($request_url);
            parse_str($parsed_url['query'], $query_string);

            // get the verifier value
            $verifier = $query_string['verifier'] ?? null;
            if (is_null($verifier)) {
                http_response_code(422);
                exit("Error: missing verifier");
            }

            // rebuild url without the verifier
            unset($query_string['verifier']);
            $hashless_url = $protocol.'://'.$parsed_url['host'].$parsed_url['path'].'?'.http_build_query($query_string, "", "&", PHP_QUERY_RFC3986);

            // calculate the hash and verify it matches the provided one
            $calculated_hash = hash_hmac('sha256', $hashless_url, $ADGEM_POSTBACK_KEY);
            if ($calculated_hash !== $verifier) {
                http_response_code(422);
                exit('Error: invalid verifier');
            }

                $user = User::Where('id',$r->player_id)->first();
                $user->points += $r->amount;
                $add_track = new trackers;
                $add_track->uid = $user->id;
                $add_track->trans_from = 'Adgem offer';
                $add_track->type = 0;
                $add_track->amount = $r->amount;
                $add_track->extra = $user->uid;
                $add_track->time = time();
                $add_track->ip = $r->ip();
                $add_track->save();
                $user->save();

                if(offer_status::Where('id',$r->player_id)->Where('offer_id',$r->campaign_id)->exists()){
                    $add_offer = offer_status::Where('id',$r->player_id)->Where('offer_id',$r->campaign_id)->first();
                    $add_offer->status = 1;
                    $add_offer->save();
                    return response()->json([
                        'error'=>'false',
                       ]);
                }
            http_response_code(200);
            exit('OK');
        }
        
    
    }
    
            public function pollfish(Request $r){
        //https://yourdomain.com/?device_id=[[device_id]]&cpa=[[cpa]]&request_uuid=[[request_uuid]]&timestamp=[[timestamp]]&tx_id=[[tx_id]]&signature=[[signature]]&status=[[status]]&reason=[[term_reason]]&reward_value=[[reward_value]]
                //Safe to proccess next
                $uid = $_GET['request_uuid'];
                $point_value = $_GET['reward_value'];
                $user = User::Where('id',$uid)->first();
                $user->points += $point_value;
                $add_track = new trackers;
                $add_track->uid = $user->id;
                $add_track->trans_from = 'Pollfish offer';
                $add_track->type = 0;
                $add_track->amount = $point_value;
                $add_track->extra = $uid;
                $add_track->time = time();
                $add_track->ip = $r->ip();
                $add_track->save();
                $user->save();
                echo 'success';
                http_response_code(200);

        }

        
            public function cpalead(Request $r){
                //https://yourdomain.com/?subid={subid}&virtual_currency={virtual_currency}&&password={password}
   
                if($r->ip()=='52.0.65.65'){
                        //Safe to proccess next
                        $uid = $_GET['subid'];
                        $point_value = $_GET['virtual_currency'];
                        $offer_title = $_GET['campaign_name'];
                        $offer_id = $_GET['campaign_id'];
                        $payout = $_GET['payout'];
                        $ip = $_GET['ip_address'];
                        $transaction_id = $_GET['lead_id'];
                        $country_iso = $_GET['country_iso'];
                        
                        $user = User::Where('id',$r->player_id)->first();
                        $user->points += $r->amount;
                        $add_track = new trackers;
                        $add_track->uid = $user->id;
                        $add_track->trans_from = 'CPALead offer';
                        $add_track->type = 0;
                        $add_track->amount = $r->amount;
                        $add_track->extra = $user->uid;
                        $add_track->time = time();
                        $add_track->ip = $r->ip();
                        $add_track->save();
                        $user->save();
        
                        echo 'success';
                        http_response_code(200);
                    

                }else {
                        echo 'failed';
                        http_response_code(301);
                    }
            }
            
            
        public function offertoro(Request $r){
        //https://yourdomain.com/?user_id={user_id}&amount={amount}&o_name={o_name}&oid={oid}&payout={payout}&ip_address={ip_address}&event={event}&conversion_ts={conversion_ts}
            if($r->ip()=="54.175.173.245"){
                //Safe to proccess next
                $uid = $_GET['user_id'];
                $point_value = $_GET['amount'];
                $offer_title = $_GET['o_name'];
                $offer_id = $_GET['oid'];
                $payout = $_GET['payout'];
            
                $user = User::Where('id',$r->user_id)->first();
                $user->points += $r->amount;
                $add_track = new trackers;
                $add_track->uid = $user->id;
                $add_track->trans_from = 'Offertoro offer';
                $add_track->type = 0;
                $add_track->amount = $r->amount;
                $add_track->extra = $user->uid;
                $add_track->time = time();
                $add_track->ip = $r->ip();
                $add_track->save();
                $user->save();

                if(offer_status::Where('uid',$uid)->Where('offer_id',$offer_id)->exists()){
                    $add_offer = offer_status::Where('uid',$r->player_id)->Where('offer_id',$offer_id)->first();
                    $add_offer->status = 1;
                    $add_offer->save();
                    return response()->json([
                        'error'=>'false',
                       ]);
                }
                echo 'success';
                http_response_code(200);
            }else{
                echo "error";
                http_response_code(301);
            }

        }
        
        public function tapjoy(Request $r){
            //?id={id}&snuid={snuid}&currency={currency}&verifier={verifier}
            if(!empty($r->verifier) & !empty($r->id) &!empty($r->snuid) &!empty($r->currency)){
                 //Safe to proccess next
                $uid = $_GET['id'];
                $point_value = $_GET['currency'];
                $user = User::Where('id',$uid)->first();
                $user->points += $r->amount;
                $add_track = new trackers;
                $add_track->uid = $user->id;
                $add_track->trans_from = 'TapJoy offer';
                $add_track->type = 0;
                $add_track->amount = $point_value;
                $add_track->extra = $uid;
                $add_track->time = time();
                $add_track->ip = $r->ip();
                $add_track->save();
                $user->save();
                echo 'success';
                http_response_code(200);
            }else{
                echo "error";
                http_response_code(301);
            }
            
        }
        
        
            
            
    public function adget(){
        //?conversion_id={conversion_id}&user_id={s1}&point_value={points}&usd_value={payout}&offer_title={vc_title}
       if($_SERVER["REMOTE_ADDR"] == "52.42.57.125")
        {
            //Safe to proccess next
            $uid = $_GET['user_id'];
            $point_value = $_GET['point_value'];
            $user = User::Where('id',$uid)->first();
            $user->points += $r->amount;
            $add_track = new trackers;
            $add_track->uid = $user->id;
            $add_track->trans_from = 'AdGetMedia offer';
            $add_track->type = 0;
            $add_track->amount = $point_value;
            $add_track->extra = $uid;
            $add_track->time = time();
            $add_track->ip = $r->ip();
            $add_track->save();
            $user->save();
            echo 'success';
            http_response_code(200);
        }
        else
        {
            echo "error";
            http_response_code(301);
        }

    }
        
        



}
