<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Admin;
use Request;



class AdminController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    use AuthorizesRequests {
        authorize as protected baseAuthorize;
    }

    public function authorize($ability, $arguments = []){
        if(\Auth::guard('admin')->check()){
            \Auth::shouldUse('admin');
        }

        $this->baseAuthorize($ability, $arguments);
    }

    public function check(Request $request){
        //act($request->license,$request->package);
        $a= new Main();
                $admin = Admin::find(1);
                $d = $a->activate_license($request->license,$request->package);
                $msg = $d['message'];
                if($d['status'])
                {
                    $admin->package_name = $p;
                    $admin->license = $c;
                    $admin->save();

                    return redirect(route('admin.dashboard'))->with('status-success', $msg);
                }else{
                    return redirect(route('admin.lic'))->with('status-alert', $msg);
                }
    }

    public function license()
    {
        return view('admin.license');
    }
}
