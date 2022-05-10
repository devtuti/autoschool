<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }
   
    public function home(){
        //$grade_count = DB::table('admins')->where('grade', '=','0')->count();
        return view('back.home');
    }

    public function admin_edit($id){
       
        $admin = DB::table('admins')
                ->where('id', $id)
                ->first();
        return view('back.system.admin_edit', compact('admin'));
       
    }

    public function admin_edit_post(Request $request, $id){
        
        $validation = [
            'username'=> 'required | min:5',
            'email'=> 'required | min:5',
            'phone'=> 'required | min:5',
            'pass'=> 'required | min:5',

        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            $update=DB::table('admins')->where('id',$id)->update([
                'name_familya'=>$request['username'],
                'email'=>$request['email'],
                'phone'=>$request['phone'],
                'password'=>$request['pass'],
                'updated_at'=>now()
            ]);
            if($update){
                return redirect()->route('admin');
            }
        }
        
    }
    
    public function admins(){
        if(Auth::guard('admin')->user()->grade==1){
            //$grade_count = DB::table('admins')->where('grade', '=','0')->count();
            $admins = DB::table('admins')->get();
            return view('back.system.admins', compact('admins'));
        }else{
          return view('back.home');
        }
    }

    public function admins_edit($id){
        //$grade_count = DB::table('admins')->where('grade', '=','0')->count();
        $admin = DB::table('admins')
                ->where('id', $id)
                ->first();
        return view('back.system.admins_edit', compact('admin'));
    }

    public function admins_edit_post(Request $request, $id){
        
            $update=DB::table('admins')->where('id',$id)->update([
                'status'=>$request['status'],
                'grade'=>$request['grade'],
                
                'updated_at'=>now()
            ]);
            if($update){
                return redirect()->route('admins');
            }
        
    }
    
}
