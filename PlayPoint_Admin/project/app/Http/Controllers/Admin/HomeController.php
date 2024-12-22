<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\settings;
use App\Models\redeems;
use App\Models\trackers;
use App\Models\offers;
use App\Models\games;
use App\Models\tournaments;
use App\Models\live_tournaments;
use App\Models\rewards;
use App\Models\reward_amounts;
use App\Models\reward_lists;
use App\Models\ad_setting;
use App\Models\visits;
use App\Models\refer_task;
use App\Models\announce;
use App\Models\banner;
use App\Models\pages;
use OneSignal;
use Image;
use DB;


class HomeController extends Controller
{

    public function index()
    {

    //box1
    $user_count = DB::select( DB::raw("SELECT id FROM users"));
    $total_user = count($user_count);
    $today_date = date('Y-m-d');
    $u_jointoday = User::where('created_at', $today_date)->count('id');
    $earn_today = number_format(trackers::where('day', $today_date)->sum('amount'));
    $pen_withd = reward_lists::where('status', 0)->count('id');
    $total_withd = reward_lists::count('id');
    $t_points = User::sum('points');
    $t_user = User::count('id');
    //box2
    $t_web = count(DB::select( DB::raw("SELECT id FROM visits")));
    $t_red_meth = count(DB::select( DB::raw("SELECT id FROM rewards")));
    $t_game = count(DB::select( DB::raw("SELECT id FROM games")));
    $t_ref_m = count(DB::select( DB::raw("SELECT id FROM refer_tasks")));
    $t_banner = count(DB::select( DB::raw("SELECT id FROM banners")));
    $t_refers = trackers::Where('trans_from','Referral bonus')->count();
    $t_rewards = reward_lists::sum('coins_used');
    //box3
    $top_ref_users = User::OrderBy('t_ref', 'DESC')->take(10)->get();
    $top_reedem = reward_lists::Where('status',0)->take(5)->get();
    //box4
    if(!empty(reward_lists::first())){
    $all_r = count(reward_lists::get()); //11
    $pen_r = count(reward_lists::Where('status',0)->get()); //5
    $apr_r = count(reward_lists::Where('status',1)->get()); //15
    $rej_r = count(reward_lists::Where('status',2)->get()); //20
    $com_r = count(reward_lists::Where('status',3)->get()); //25
    $pen_red = ($pen_r / $all_r) * 100;
    $apr_red = ($apr_r / $all_r) * 100;
    $rej_red = ($rej_r / $all_r) * 100;
    $com_red = ($com_r / $all_r) * 100;
    $t_re = str_replace("0.","",round($pen_red));
    $t_apre = str_replace("0.","",round($apr_red));
    $t_rej = str_replace("0.","",round($rej_red));
    $t_com = str_replace("0.","",round($com_red));
    }else{
    $t_re = str_replace("0.","",round(0));
    $t_apre = str_replace("0.","",round(0));
    $t_rej = str_replace("0.","",round(0));
    $t_com = str_replace("0.","",round(0));
    }
    //box5
    $yday = date('Y-m-d',strtotime('-1 days'));
    $tday = date('Y-m-d');

    $coi_yes_grf = trackers::where('day', $yday)->sum('amount');
    $coi_to_grf = trackers::where('day', $tday)->sum('amount');
    //box6
    $yday_u = User::where('created_at', $yday)->count();
    $tday_u = User::where('created_at', $tday)->count();
    //box6
    $yday_u = User::where('created_at', $yday)->count();
    $tday_u = User::where('created_at', $tday)->count();
    //box7
    $yday_r = trackers::where('day', $yday)->where('trans_from','Referral bonus')->count();
    $tday_r = trackers::where('day', $tday)->where('trans_from','Referral bonus')->count();

    return view('admin.dashboard',[
    't_points' => $t_points,
    't_user' => $t_user,
    'u_jointoday' => $u_jointoday,
    'total_user' => $total_user,
    'total_withd' => $total_withd,
    'pen_withd' => $pen_withd,
    'earn_today' => $earn_today,
    't_web' => $t_web,
    't_red_meth' => $t_red_meth,
    't_game' => $t_game,
    't_ref_m' => $t_ref_m,
    't_banner' => $t_banner,
    't_refers' => $t_refers,
    't_rewards' => $t_rewards,
    'top_ref_users' => $top_ref_users,
    'top_reedem' => $top_reedem,
    't_re' => $t_re,
    't_apre' => $t_apre,
    't_rej' => $t_rej,
    't_com' => $t_com,
    'coi_yes_grf' => $coi_yes_grf,
    'coi_to_grf' => $coi_to_grf,
    'yday_u' => $yday_u,
    'tday_u' => $tday_u,
    'yday_r' => $yday_r,
    'tday_r' => $tday_r,
    ]);
    }

    public function t_referrals()
    {
     $refers = trackers::join("users",'users.id','trackers.uid')
     ->select('users.*', 'trackers.extra')
     ->Where('trans_from','Referral join bonus')->OrderBy('trackers.id', 'DESC')->paginate(10);
     return view('admin.referrals', ['refers'=>$refers]);
    }

    public function users(Request $request)
    {
       $users = User::latest()->paginate(15);
      return view('admin.users.users', ['users'=>$users]);
    }
    
    public function users_search(Request $request,$data)
    {
   
      $users = User::query()
      ->where('email', 'LIKE', "%{$data}%")
      ->orWhere('name', 'LIKE', "%{$data}%")
      ->orWhere('id', 'LIKE', "%{$data}%")
      ->latest()
      ->paginate(15);
      $users->appends($users->all());
      return view('admin.users.search_user', compact('users','data'));
      
    }

    public function edit_user($id)
    {
     $user_data = User::find($id);
     return view('admin.users.edit_user', ['user_data'=>$user_data]);
    }

    public function update_user(Request $request, $id)
    {
       $user = User::find($id);
       $user->name =$request['name'];
       $user->points =$request['points'];
       $user->status =$request['status'];
       $user->save();
       return redirect(route('admin.useredit', ['id' => $id]))->with('status-success', 'User Has Been updated');
    }

    public function login()
    {
        $admin = Admin::where('id',1)->first();

        return view('admin.auth.login',['admin' => $admin]);
    }

    public function redeem(Request $request)
    {

        $search = $request->input('status');
        $usersearch = $request->input('user');

        if(isset($usersearch)){
        $userdata = reward_lists::query()
        ->where('email', 'LIKE', "%{$usersearch}%")
        ->orWhere('name', 'LIKE', "%{$usersearch}%")
        ->orWhere('user_id', 'LIKE', "%{$usersearch}%")
        ->paginate(10);
        $userdata->appends($request->all());
        return view('admin.redeem.redeem', compact('userdata'));
        }
        else
        {
        if(isset($search)){
        $userdata = reward_lists::OrderBy('id', 'DESC')->where('status', $search)->paginate(15);
        }
        else
        {
        $userdata = reward_lists::OrderBy('id', 'DESC')->paginate(15);
        }
        return view('admin.redeem.redeem', ['userdata'=>$userdata]);
      }
    }
    
    public function redeem_status($id)
    {
        $userdata = reward_lists::OrderBy('id', 'DESC')->where('status', $id)->paginate(20);
        return view('admin.redeem.redeem_status', ['userdata'=>$userdata,'sid'=>$id]);
    }

    public function request_view($id)
    {
      $withdrawal_data = reward_lists::find($id);
      $user_data = User::find($withdrawal_data->user_id);
      return view('admin.redeem.request_view', ['withdrawal_data'=>$withdrawal_data, 'user_data'=>$user_data]);
    }

    public function update_request_view(Request $request, $id)
    {
       $redeem_req = reward_lists::find($id);
       $redeem_req->status =$request['status'];
       $redeem_req->save();
       return redirect(route('admin.with_reqs_up', ['id' => $id]))->with('status-success', 'User Redeem Has Been updated');
    }

    public function games(Request $request)
    {
        $games = games::paginate(15);
        return view('admin.games.games',['games' => $games]);
    }

    public function edit_game($id)
    {
     $game_data = games::find($id);
     return view('admin.games.edit_game', ['game_data'=>$game_data]);
    }

    public function update_game(Request $request, $id)
    {
       //dd($request->all());
        if($request->hasFile('csmimage')) {
        $avatar = $request->file('csmimage');
        $filename = 'codesellmarket-' . time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->save('images/csm/'.$filename);
        $imagePath = '/images/csm/'.$filename;
        }
       $user = games::find($id);
       $user->title =$request['title'];
       $user->game =$request['g_url'];
       $user->coins =$request['coins'];
       $user->time =$request['time'];
       $user->category =$request['category'];
       $user->screen =$request['screen'];
       if(!empty($imagePath)){
       $user->image = $imagePath;
       }
       $user->save();
       return redirect(route('admin.games'))->with('status-success', 'Game Has Been updated');
    }

    public function add_game()
    {
      return view('admin.games.add_game');
    }

    public function post_game(Request $request)
    {
       $game = new games;
       $avatar = $request->file('csmimage');
       $filename = 'codesellmarket-' . time() . '.' . $avatar->getClientOriginalExtension();
       Image::make($avatar)->save('images/csm/'.$filename);
       $imagePath = '/images/csm/'.$filename;

       $game->title =$request['title'];
       $game->game =$request['g_url'];
       $game->coins =$request['coins'];
       $game->time =$request['time'];
       $game->category =$request['category'];
       $game->screen =$request['screen'];
       $game->image = $imagePath;
       $game->save();
       return redirect(route('admin.games'))->with('status-success', 'Game Has Been added');
    }

    public function csm_delete_game($id){
    
      DB::delete('delete from games where id = ?',[$id]);
      return redirect(route('admin.games'))->with('status-alert', 'Game Has Been deleted');
    }

    //csm devs visit & earn start
    public function visit(Request $request)
    {

        $games = visits::paginate(15);
        return view('admin.visit.visit',['games' => $games]);
    }

    public function edit_visit($id)
    {
     $game_data = visits::find($id);
     return view('admin.visit.edit_visit', ['game_data'=>$game_data]);
    }

    public function update_visit(Request $request, $id)
    {

       $user = visits::find($id);
       $user->title =$request['title'];
       $user->link =$request['link'];
       $user->coins =$request['coins'];
       $user->time =$request['time'];
       $user->save();
       return redirect(route('admin.visit'))->with('status-success', 'Visit Web Has Been updated');
    }

    public function add_visit()
    {
      return view('admin.visit.add_visit');
    }

    public function post_visit(Request $request)
    {

        $user = new visits;
        $user->title =$request['title'];
        $user->link =$request['link'];
        $user->coins =$request['coins'];
        $user->time =$request['time'];
       $user->save();
       return redirect(route('admin.visit'))->with('status-success', 'Visit Web Has Been added');
    }

    public function csm_delete_visit($id){
        
        DB::delete('delete from visits where id = ?',[$id]);
        return redirect(route('admin.visit'))->with('status-alert', 'Visit Web Has Been deleted');
      }
    //csm devs visit & earn end

     //csm Refer Tasks start
     public function refer(Request $request)
     {

         $games = refer_task::paginate(15);
         return view('admin.refer.refer',['games' => $games]);
     }

     public function edit_refer($id)
     {
      $game_data = refer_task::find($id);
      return view('admin.refer.edit_refer', ['game_data'=>$game_data]);
     }

     public function update_refer(Request $request, $id)
     {

        $user = refer_task::find($id);
        $user->coins =$request['coins'];
        $user->refers =$request['refers'];
        $user->save();
        return redirect(route('admin.refer'))->with('status-success', 'Refer Task Has Been updated');
     }

     public function add_refer()
     {
       return view('admin.refer.add_refer');
     }

     public function post_refer(Request $request)
     {

        $user = new refer_task;
        $user->coins =$request['coins'];
        $user->refers =$request['refers'];
        $user->save();
        return redirect(route('admin.refer'))->with('status-success', 'Refer Task Has Been added');
     }

     public function csm_delete_refer($id){
         
         DB::delete('delete from refer_tasks where id = ?',[$id]);
         return redirect(route('admin.refer'))->with('status-alert', 'Refer Task Has Been deleted');
     }
     //csm devs Refer Tasks end

     //csm devs offerwall start
     public function offerwalls()
     {
        $offers = ad_setting::where('type',1)->paginate(15);
        return view('admin.offerwalls.offerwalls', ['offers'=>$offers]);
     }

     public function edit_offerwalls($id)
     {
       $offerwalls_data = ad_setting::find($id);
       return view('admin.offerwalls.edit_offer', ['offerwalls_data'=>$offerwalls_data]);
     }

     public function update_offerwall(Request $request, $id)
     {

        if($request->keyid=="adget"){
        $myObj = new \stdClass();
        $myObj->AdGateMedia_Wallcode = $request->AdGateMedia_Wallcode;
        $myObj->api_key = $request->api_key;
        $myObj->aff_id = $request->aff_id;
        $myObj->api_status = $request->api_status;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="offertoro"){
        $myObj = new \stdClass();
        $myObj->offertoro_app_id = $request->offertoro_app_id;
        $myObj->offertoro_secret_key = $request->offertoro_secret_key;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="is"){
        $myObj = new \stdClass();
        $myObj->ironsource_appkey = $request->ironsource_appkey;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="tj"){
        $myObj = new \stdClass();
        $myObj->tapjoy_sdk_key = $request->tapjoy_sdk_key;
        $myObj->tapjoy_offerwall_name = $request->tapjoy_offerwall_name;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="adgem"){
        $myObj = new \stdClass();
        $myObj->adgem_app_id = $request->adgem_app_id;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="cpalead"){
        $myObj = new \stdClass();
        $myObj->cpa_lead_offerwall_url = $request->cpa_lead_offerwall_url;
        $myJSON = json_encode($myObj);

        }else{
        return false;
        }

        if($request->hasFile('csmimage')) {
        $avatar = $request->file('csmimage');
        $filename = 'codesellmarket-' . time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->save('images/csm/'.$filename);
        $imagePath = '/images/csm/'.$filename;
        }

        $offer = ad_setting::find($id);
        $offer->name =$request['title'];
        $offer->status =$request['status'];
        if(!empty($imagePath)){ $offer->image = $imagePath; }
        $offer->ids = $myJSON;
        $offer->save();
        return redirect(route('admin.offerwalls', ['id' => $id]))->with('status-success', 'OfferWall Has Been updated');
     }

     //csm devs offerwall end


     //csm devs ads & videos start
     public function ads()
     {
        $offers = ad_setting::where('type',0)->paginate(15);
        return view('admin.ads.ads', ['offers'=>$offers]);
     }

     public function edit_ads($id)
     {
       $offerwalls_data = ad_setting::find($id);
       return view('admin.ads.edit_ads', ['offerwalls_data'=>$offerwalls_data]);
     }

     public function update_ads(Request $request, $id)
     {

        if($request->keyid=="unity"){
        $myObj = new \stdClass();
        $myObj->video_coins = $request->video_coins;
        $myObj->video_limit = $request->video_limit;
        $myObj->game_id = $request->game_id;
        $myObj->reward_ad_id = $request->reward_ad_id;
        $myObj->interstitial_ad_id = $request->interstitial_ad_id;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="fb"){
        $myObj = new \stdClass();
        $myObj->video_coins = $request->video_coins;
        $myObj->video_limit = $request->video_limit;
        $myObj->reward_ad_id = $request->reward_ad_id;
        $myObj->interstitial_ad_id = $request->interstitial_ad_id;
        //$myObj->banner_ad_id = $request->banner_ad_id;
        //$myObj->native_ad_id = $request->native_ad_id;
        //$myObj->ntive_banner_ad_id = $request->ntive_banner_ad_id;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="admob"){
        $myObj = new \stdClass();
        $myObj->video_coins = $request->video_coins;
        $myObj->video_limit = $request->video_limit;
        $myObj->reward_ad_id = $request->reward_ad_id;
        $myObj->Interstitial_Ad_Unit = $request->Interstitial_Ad_Unit;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="adColony"){
        $myObj = new \stdClass();
        $myObj->video_coins = $request->video_coins;
        $myObj->video_limit = $request->video_limit;
        $myObj->app_id = $request->app_id;
        $myObj->Interstitial_Ad_Id = $request->Interstitial_Ad_Id;
        $myObj->reward_ad_id = $request->reward_ad_id;
        $myObj->app_id = $request->app_id;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="max"){
        $myObj = new \stdClass();
        $myObj->video_coins = $request->video_coins;
        $myObj->video_limit = $request->video_limit;
        $myObj->Interstitial_Ad_Unit = $request->Interstitial_Ad_Unit;
        $myObj->Reward_Ad_Unit = $request->Reward_Ad_Unit;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="startapp"){
        $myObj = new \stdClass();
        $myObj->video_coins = $request->video_coins;
        $myObj->video_limit = $request->video_limit;
        $myObj->app_id = $request->app_id;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="vungle"){
        $myObj = new \stdClass();
        $myObj->video_coins = $request->video_coins;
        $myObj->video_limit = $request->video_limit;
        $myObj->app_id = $request->app_id;
        $myObj->InterstitialPlacementId = $request->InterstitialPlacementId;
        $myObj->RewardPlacementId = $request->RewardPlacementId;
        $myJSON = json_encode($myObj);

        }elseif($request->keyid=="chartboost"){
        $myObj = new \stdClass();
        $myObj->video_coins = $request->video_coins;
        $myObj->video_limit = $request->video_limit;
        $myObj->app_id = $request->app_id;
        $myObj->appSignature = $request->appSignature;
        $myObj->interstitial_location_name = $request->interstitial_location_name;
        $myObj->reward_location_name = $request->reward_location_name;
        $myJSON = json_encode($myObj);

        }else{
        return false;
        }

        if($request->hasFile('csmimage')) {
        $avatar = $request->file('csmimage');
        $filename = 'codesellmarket-' . time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->save('images/csm/'.$filename);
        $imagePath = '/images/csm/'.$filename;
        }

        $offer = ad_setting::find($id);
        $offer->name =$request['title'];
        $offer->status = $request['status'];
        if(!empty($imagePath)){ $offer->image = $imagePath; }
        $offer->ids = $myJSON;
        $offer->save();
        return redirect(route('admin.edit_ads', ['id' => $id]))->with('status-success', 'Ad Has Been updated');
     }
     //csm devs ads & videos end


    public function redeem_methods(Request $request)
    {
        $userdata = rewards::paginate(15);
        return view('admin.reward.rewards',['userdata' => $userdata]);
    }

    public function edit_rm($id)
    {
     $user_data = rewards::find($id);
     return view('admin.reward.edit_rm', ['user_data'=>$user_data]);
    }

    public function update_rm(Request $request, $id)
    {

        if($request->hasFile('csmimage')) {
        $avatar = $request->file('csmimage');
        $filename = 'codesellmarket-' . time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->save('images/csm/'.$filename);
        $imagePath = '/images/csm/'.$filename;
        }

       $user = rewards::find($id);
       $user->name =$request['name'];
       $user->hint =$request['hint'];
       $user->symbol =$request['symbol'];
       $user->input_type =$request['input_type'];
       $user->details =$request['note'];
       if(!empty($imagePath)){ $user->image = $imagePath; }
       $user->status =$request['status'];
       $user->save();
       return redirect(route('admin.redeem_methods'))->with('status-success', 'Redeem Has Been updated');
    }

    public function edit_rm_amounts($id)
    {
     $userdata = reward_amounts::where('r_id',$id)->paginate(8);
     return view('admin.reward.edit_rm_amounts', ['userdata' => $userdata]);
    }

    public function add_rm_method(){
        return view('admin.reward.add_rm_method');
     }

     public function create_rm_method(Request $request)
    {

        $validated = $request->validate([
        'name' => 'required',
        'csmimage' => 'required',
        'hint' => 'required',
        'symbol' => 'required',
        'input_type' => 'required',
        'note' => 'required',
        'status' => 'required',
        ]);

        $avatar = $request->file('csmimage');
       $filename = 'codesellmarket-' . time() . '.' . $avatar->getClientOriginalExtension();
       Image::make($avatar)->save('images/csm/'.$filename);
       $imagePath = '/images/csm/'.$filename;

        //dd($request->all());
       $user = new rewards;
       $user->name =$request['name'];
       $user->image = $imagePath;
       $user->hint =$request['hint'];
       $user->symbol =$request['symbol'];
       $user->input_type =$request['input_type'];
       $user->details =$request['note'];
       $user->status =$request['status'];
       $user->save();
       return redirect(route('admin.redeem_methods'))->with('status-success', 'Redeem Has Been created');
    }

    public function create_rm_amounts(Request $request, $id)
    {
       //dd($request->all());
       $validated = $request->validate([
        'amount' => 'required',
        'coins' => 'required',
        ]);

       $user = new reward_amounts;
       $user->amount =$request['amount'];
       $user->coins =$request['coins'];
       $user->r_id = $id;
       $user->save();
       return redirect(route('admin.edit_rm_amounts', ['id' => $id]))->with('status-success', 'Amount Has Been created');
    }

    public function delete_rm_amounts($id) {
        
        DB::delete('delete from reward_amounts where id = ?',[$id]);
        return redirect()->back()->with('status-alert', 'Amount Has Been deleted');
    }

    public function delete_rm($id) {
        
        DB::delete('delete from rewards where id = ?',[$id]);
        return redirect()->back()->with('status-alert', 'Redeem Has Been deleted');
    }


    public function tracker(Request $request)
    {
        $user = $request->input('user');
        if(isset($user)){
        $userdata = trackers::where('uid',$user)->latest()->paginate(20);
        return view('admin.tracker',['userdata' => $userdata]);
        }

        $userdata = trackers::latest()->paginate(20);
        return view('admin.tracker',['userdata' => $userdata]);
    }


    public function tracker_u($id)
    {
        $userdata = trackers::where('uid',$id)->latest()->paginate(20);
        return view('admin.tracker_u',['userdata' => $userdata,'uid' => $id]);
    }


    public function settings()
    {
        $settings = settings::where('id',1)->first();
        return view('admin.settings.settings',['settings' => $settings]);
    }
    
    public function fraud_prevention_settings()
    {
        $settings = settings::where('id',1)->first();
        return view('admin.settings.fraud_prevention_settings',['settings' => $settings]);
    }
    
    
    public function csm_app_settings()
    {
        $ads = ad_setting::select('net_id','name')->where('type',0)->get();
        $settings = settings::where('id',1)->first();
        return view('admin.settings.csm_app_settings',['settings' => $settings,'ads'=>$ads]);
    }

    public function update_settings(Request $request)
    {

        if(!empty($request->new_password)){
        $request->validate([
        'new_password' => ['required'],
        'new_confirm_password' => ['same:new_password'],
        ]);

        Admin::find(1)->update(['password'=> Hash::make($request->new_password)]);
        }

        if($request->hasFile('csmimage')) {
        $avatar = $request->file('csmimage');
        $filename = 'codesellmarket-noti-' . time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->save('images/csm/'.$filename);
        $imagePath = '/images/csm/'.$filename;
        }

       $user = Admin::find(1);
       $user->name =$request['name'];
       $user->email =$request['email'];
       $user->site_name =$request['name'];
       if(!empty($request->profile)){

        $avatar = $request->file('profile');
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->fit(120, 120)->save(public_path('/images/avatar/'.$filename));
        $avatarPath = '/images/avatar/'.$filename;

       $user->profile_image = $avatarPath;
       }

       if(!empty($imagePath)){
       $user->profile_logo = $imagePath;
       }
       $user->save();
       return redirect(route('admin.settings'))->with('status-success', 'Account settings has been updated');
    }

    public function update_app_settings(Request $request)
    {

        $user = settings::find(1);
        $input = $request->all();
        $user->fill($input)->save();
        $user->save();
       return redirect(route('admin.settings'))->with('status-success', 'App settings has been updated');
    }

    public function up_daily_streak_settings(Request $request)
    {

         $validated = $request->validate([
        'day_1' => 'required',
        'day_2' => 'required',
        'day_3' => 'required',
        'day_4' => 'required',
        'day_5' => 'required',
        'day_6' => 'required',
        'day_7' => 'required',
        ]);


        $myObj = new \stdClass();
        $myObj->day_1 = $request->day_1;
        $myObj->day_2 = $request->day_2;
        $myObj->day_3 = $request->day_3;
        $myObj->day_4 = $request->day_4;
        $myObj->day_5 = $request->day_5;
        $myObj->day_6 = $request->day_6;
        $myObj->day_7 = $request->day_7;

        $myJSON = json_encode($myObj);

        $user = settings::find(1);
        $user->days = $myJSON;
        $user->save();
       return redirect(route('admin.csm_app_settings'))->with('status-success', 'Daily Login Coin has been updated');
    }

    public function up_fraud_prevention(Request $request)
    {

        //dd($request->all());
        $user = settings::find(1);
        if($request->vpn=="0"){
        $user->vpn = 0;
        }else{
        $user->vpn = 1;
        }
        
        if($request->one_device=="0"){
        $user->one_device = 0;
        }else{
        $user->one_device = 1;
        }
        
        if($request->vpn_ban=="0"){
        $user->vpn_ban = 0;
        }else{
        $user->vpn_ban = 1;
        }
        
        if($request->devOption=="0"){
        $user->devOption = 0;
        }else{
        $user->devOption = 1;
        }

        $user->save();
       return redirect(route('admin.fraud_prevention'))->with('status-success', 'Fraud Prevention setting has been updated');
    }
    
    public function up_app_settings(Request $request)
    {
      $user = settings::find(1);
      
      if(isset($request->spin)){
          
       $user->daily_spin = $request->spin;
       $user->spin_ad = $request->net;
       $user->spin_ad_int = $request->ad_spin_int;
       
       $user->save();
       return redirect(route('admin.csm_app_settings'))->with('status-success', 'Spin setting has been updated');
          
      }elseif(isset($request->scratch)){
          
       $user->daily_scratch = $request->scratch;
       $user->scratch_ad = $request->net;
       $user->scratch_coins = $request->scratch_coins;
       $user->scratch_ad_int = $request->ad_scratch_int;
       
       $user->save();
       return redirect(route('admin.csm_app_settings'))->with('status-success', 'Scratch setting has been updated');
       
      }elseif(isset($request->games)){
          
       $user->game_ad = $request->net;
       $user->game_ad_int = $request->ad_claim_int; 
       
       $user->save();
       return redirect(route('admin.csm_app_settings'))->with('status-success', 'Games setting has been updated');
          
      }elseif(isset($request->refers)){
          
       $user->refer_points = $request->refer_points;
       $user->refer_bonus = $request->refer_bonus;
       $user->package_name = $request->package_name;
       $user->referMessage = $request->refer_msg;
       $user->refer_type = $request->refer_type;
       
       $user->save();
       return redirect(route('admin.csm_app_settings'))->with('status-success', 'Refer setting has been updated');
          
      }elseif(isset($request->app_ads)){
          
       $user->x2_ad = $request->x2_ad;
       $user->back_ad = $request->back_net;
       $user->back_ad_int = $request->ad_back_int; 
       
       $user->save();
       return redirect(route('admin.csm_app_settings'))->with('status-success', 'App Ads setting has been updated');
        
      }else{ }
      
      
    }
    
    public function app_mode(Request $request)
    {

        $app_m = $request->app_mode;
        $app_debug = $request->debug_mode;
        $app_url = $request->app_url;
        
        $one_app_id = $request->one_app_id;
        $one_rest_key = $request->one_rest_key;
        
        if($app_m==1){
        $path = base_path('.env');
        $enccon = file_get_contents($path);
        if(file_exists($path)) {
          file_put_contents($path, str_replace('APP_ENV=local', 'APP_ENV=production', $enccon));
        }
        }elseif($app_m==0){
         $path = base_path('.env');
        $enccon = file_get_contents($path);
        if (file_exists($path)) {
         file_put_contents($path, str_replace('APP_ENV=production', 'APP_ENV=local', $enccon));
        }   
        }else{}
        
        if($app_debug==1){
        $path = base_path('.env');
        $enccon = file_get_contents($path);
        if (file_exists($path)) {
          file_put_contents($path, str_replace('APP_DEBUG=false', 'APP_DEBUG=true', $enccon));
        }
        }elseif($app_debug==0){
         $path = base_path('.env');
        $enccon = file_get_contents($path);
        if(file_exists($path)) {
         file_put_contents($path, str_replace('APP_DEBUG=true', 'APP_DEBUG=false', $enccon));
        }   
        }else{}
        
        if(env('APP_URL')!=$app_url){
        $path = base_path('.env');
        $enccon = file_get_contents($path);
        $url = env('APP_URL');
        if (file_exists($path)) {
          file_put_contents($path, str_replace('APP_URL='.$url, 'APP_URL='.$app_url, $enccon));
        }
        }
        
        if(env('ONESIGNAL_APP_ID')!=$one_app_id){
        $path = base_path('.env');
        $enccon = file_get_contents($path);
        $o_app_id = env('ONESIGNAL_APP_ID');
        if (file_exists($path)) {
          file_put_contents($path, str_replace('ONESIGNAL_APP_ID='.$o_app_id, 'ONESIGNAL_APP_ID='.$one_app_id, $enccon));
        }
        }
        
        if(env('ONESIGNAL_REST_API_KEY')!=$one_rest_key){
        $path = base_path('.env');
        $enccon = file_get_contents($path);
        $o_app_rest = env('ONESIGNAL_REST_API_KEY');
        if (file_exists($path)) {
          file_put_contents($path, str_replace('ONESIGNAL_REST_API_KEY='.$o_app_rest, 'ONESIGNAL_REST_API_KEY='.$one_rest_key, $enccon));
        }
        }
        

       return redirect(route('admin.settings'))->with('status-success', 'App Configuration has been updated');
    }

    //csm devs noti start
    public function csm_noti()
    {
    $noti = announce::paginate(15);
    return view('admin.csm_noti',['noti' => $noti]);
    }
    
    public function admin_del_user($id){
        
      DB::delete('delete from users where id = ?',[$id]);
      return redirect(route('admin.users'))->with('status-success', 'User Has Been deleted successfully.');
    }

    public function push(Request $request)
    {
        if($request->hasFile('csmimage')) {
        $avatar = $request->file('csmimage');
        $filename = 'codesellmarket-noti-' . time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->save('images/csm/'.$filename);
        $imagePath = '/images/csm/'.$filename;
        $fullurl = url($imagePath);
        }

        $user = new announce;
        $params = [];
        if(!empty($fullurl)){
        $params['big_picture'] = $fullurl;
        $user->image = $fullurl;
        }
        if($request->url!=null){
        $params['url'] = $request->url;
        }
        $params['headings'] = [ "en"=>$request->title ];
        $message = $request->sub;
        OneSignal::addParams($params)->sendNotificationToAll($message);

        $user->title =$request['title'];
        $user->sub =$request['sub'];
        $user->date = date('d-m-Y');
        $user->save();

        return redirect(route('admin.csm_noti'))->with('status-success', 'Notification has been send..!');
    }

    public function csm_delete_noti($id) {
        
        DB::delete('delete from announces where id = ?',[$id]);
        return redirect(route('admin.csm_noti'))->with('status-alert', 'Notification Has Been deleted');
    }
    //csm devs noti end

    //csm devs banners start
    public function csm_banners()
    {
    $noti = banner::paginate(15);
    return view('admin.csm_banner',['noti' => $noti]);
    }

    public function banners_add(Request $request)
    {

    if($request->hasFile('csmimage')) {
    $avatar = $request->file('csmimage');
    $filename = 'codesellmarket-noti-' . time() . '.' . $avatar->getClientOriginalExtension();
    Image::make($avatar)->save('images/csm/'.$filename);
    $imagePath = '/images/csm/'.$filename;
    $fullurl = $imagePath;
    }

    $user = new banner;
    $user->title =$request['title'];
    $user->sub =$request['sub'];
    $user->url =$request['url'];
    $user->image = $fullurl;
    $user->save();

    return redirect(route('admin.csm_banners'))->with('status-success', 'Banner has been Added!');
    }

    public function csm_delete_banners($id) {
        
        DB::delete('delete from banners where id = ?',[$id]);
        return redirect(route('admin.csm_banners'))->with('status-alert', 'Banner Has Been deleted');
    }

    public function csm_status_banners($id,$id2) {
        
        $user = banner::find($id);
        $user->status = $id2;
        $user->save();
        return redirect(route('admin.csm_banners'))->with('status-success', 'Status Has Been updated');
    }
    //csm devs noti end

    public function license()
    {
       return view('admin.csm_license');
    }

    public function activate(Request $request)
    {

        $this_server_name = getenv('SERVER_NAME')?:
        $_SERVER['SERVER_NAME']?:
        getenv('HTTP_HOST')?:
        $_SERVER['HTTP_HOST'];
        $this_http_or_https = ((
        (isset($_SERVER['HTTPS'])&&($_SERVER['HTTPS']=="on"))or
        (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])and
        $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        )?'https://':'http://');
        $this_url = $this_http_or_https.$this_server_name.$_SERVER['REQUEST_URI'];

        $this_ip = getenv('SERVER_ADDR')?:
        $_SERVER['SERVER_ADDR']?:
        $this->get_ip_from_third_party()?:
        gethostbyname(gethostname());
        
          $pieces = parse_url($this_url);
          $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
          if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            $hostPath = $regs['domain'];
          }

        $post = [
            'api_key' => 'e1e5bc06-de7a-4b58-89a6-22db256bad59',
            'license_key' => $request->license,
            'identifier'   => '1',
            'post_url'   => $request->package,
        ];
        
        $ch = curl_init('https://codex.propernaam.xyz/api/v1/activate');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        
        // execute!
        $response = curl_exec($ch);
        
        // close the connection, release resources used
        curl_close($ch);
        
        // do anything you want with your response
        $data = json_decode($response);
        
        $result = $data->response;
        $msg = $result->message;
        
        if($result->code==300){
            $admin = Admin::find(1);
            $admin->license = $request->license;
            $admin->package_name = $request->package;
            $admin->save();
            return redirect(route('admin.dashboard'))->with('status-success', $msg);
        }else{
            return redirect(route('admin.license'))->with('status-alert', $msg);
        }
        
    }

    public function csm_status_user($id,$id2){
    
    $user = User::find($id);
    $user->status = $id2;
    $user->save();
    return redirect(route('admin.users', ['id' => $id]))->with('status-success', 'Status Has Been updated');
    }

    public function postbacks()
     {
       return view('admin.postbacks');
     }

     public function file_resources()
     {
       return view('admin.resources');
     }

     public function delete_file_resources($file)
     {
        
         $file_path = 'images/csm/'.$file;
         unlink($file_path);
         return redirect(route('admin.file_resources'))->with('status-success', 'Image Successfully deleted');
     }

     public function web_pages($slug)
     {
      $pages = pages::where('status', 1)->where('slug', $slug)->first();
      if(empty($pages)){ abort(404); }
      return view('admin.pages.view', ['pages'=>$pages]);
     }

     public function pages()
    {
      $pages = pages::paginate(15);
      return view('admin.pages.all', ['pages'=>$pages]);
    }

    public function edit_page($id)
    {
     $page_data = pages::find($id);
     return view('admin.pages.edit', ['page_data'=>$page_data]);
    }

    public function update_page(Request $request, $id)
    {
       $page = pages::find($id);
       $page->title = $request['title'];
       $page->desc = $request['desc'];
       $page->status = $request['status'];
       $page->save();
       return redirect(route('admin.pages'))->with('status-success', 'Page Has Been updated');
    }
    
    public function account_deletion()
    {
     return view('admin.account_deletion');
    }

}
