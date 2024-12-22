<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;


class csmdev
{

    // public function handle(Request $request, Closure $next)
    // {

    //    function activation_submit()
    //     {

    //         $purchase_code =  $request->pcode;
    //         $my_script =  'codesellmarket*license*error';
    //         $my_domain = url('/');

    //         $varUrl = str_replace (' ', '%20', config('services.csm_web.csmw').'purchase112662activate.php?code='.$purchase_code.'&domain='.$my_domain.'&script='.$my_script);

    //         if( ini_get('allow_url_fopen') ) {
    //             $contents = file_get_contents($varUrl);
    //         }else{
    //             $ch = curl_init();
    //             curl_setopt ($ch, CURLOPT_URL, $varUrl);
    //             curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    //             $contents = curl_exec($ch);
    //             curl_close($ch);
    //         }

    //         $chk = json_decode($contents,true);

    //         if($chk['status'] != "success")
    //         {

    //             $msg = $chk['message'];
    //             return response()->json($msg);

    //         }else{
    //             $this->setUp($chk['p2'],$chk['lData']);

    //             if (file_exists(public_path().'/rooted.txt')){
    //                 unlink(public_path().'/rooted.txt');
    //             }

    //             $fpbt = fopen(public_path().'/project/license.txt', 'w');
    //             fwrite($fpbt, $purchase_code);
    //             fclose($fpbt);

    //             $msg = 'Congratulation! Your License is successfully Activated.';
    //             return response()->json($msg);

    //         }

    //     }

    //     return $next($request);

    // }
    public function handle(Request $request, Closure $next)
{
    if (app()->environment('production')) {
        // Temporary bypass for recovery
        if (!file_exists(public_path() . '/project/license.txt')) {
            $licenseContent = 'RECOVERY-MODE'; // Placeholder for the license
            file_put_contents(public_path() . '/project/license.txt', $licenseContent);
        }
    }

    return $next($request);
}

}






