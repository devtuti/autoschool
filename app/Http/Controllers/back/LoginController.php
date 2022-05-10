<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        return view('back.login');
    }

    public function userlogin(Request $request){
        $validation = [
            'adminname'=> 'required',
            'pass' => 'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            if(Auth::guard('admin')->attempt(['name_familya'=>$request->adminname, 'password'=>$request->pass])){
                return redirect()->route('admin');
            }
            return redirect()->route('login')->withErrors('Xeta var');
        }
    }

    public function exit(){
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
