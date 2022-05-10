<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;

class RegisterController extends Controller
{
    public function register(){
        return view('back.registration');
    }

    public function userregister(Request $request){
        $validation = [
            'username'=> 'required|string',
            'email'=> 'required| email| unique:users',
            'phone' => 'required',
            'password' => 'min:6|confirmed|required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            
                $data=array(
                    'name_familya'=>$request->username,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'password'=>bcrypt($request->password),
                    'created_at'=>now()
                ); //dd($data);
                
                    $admins = DB::table('admins')->get();
                    foreach($admins as $admin){
                        if($admin->name_familya != $request->username or $admin->email!=$request->email){
                            Admin::insert($data);
                            return redirect()->route('login');
                        }else{
                            return redirect()->route('register')->withErrors('Bu ad yaxud bu email qeydiyyatdan kecib..');
                        }
                    }
               
        }
        
    }
}
