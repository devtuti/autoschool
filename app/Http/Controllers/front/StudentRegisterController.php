<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StudentRegisterController extends Controller
{
    public function register(){
        $teachers = DB::table('admins')->where('grade', '=', '2')->get();
        return view('front.student_register', compact('teachers'));
    }

    public function studentregister(Request $request){
        $validation = [
            'username'=> 'required| string',
            'email'=> 'required| email| unique:users',
            'teacher' => 'required',
            'password' =>'min:6|confirmed|required',
            //'confirm_pass' => 'required| min:5',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            $password = Hash::make($request->password);//bcrypt($request->pass);
                $data=array(
                    'name'=>$request->username,
                    'email'=>$request->email,
                    'teacher_id'=>$request->teacher,
                    'password'=>$password,
                    'photo'=>'profile.png',
                    'created_at'=>now()
                ); //dd($data); die;
                
                    $users = DB::table('users')->get();
                    foreach($users as $user){
                        if($user->name != $request->username or $user->email!=$request->email){
                            User::insert($data);
                            return redirect()->route('studentlogin');
                        }else{
                            return redirect()->route('studentregister')->withErrors('Bu ad yaxud bu email qeydiyyatdan kecib..');
                        }
                    }
                    
        }
        
    }
}
