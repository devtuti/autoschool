<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }

    public function users(){
        if(Auth::guard('admin')->user()->grade==2){
            //$grade_count = DB::table('admins')->where('grade', '=','0')->count();
            $users = DB::table('users')
                    ->join('admins', 'admins.id', 'users.teacher_id')
                    ->select('users.*', 'admins.*', 'users.id as u_id', 'users.email as u_email', 'users.status as u_status', 'users.created_at as u_created_at', 'users.updated_at as u_updated_at')
                    ->get();
            return view('back.system.users', compact('users'));
        }else{
          return view('back.home');
        }
    }

    public function users_edit($id){
        
        if(Auth::guard('admin')->user()->grade==2){
        $user = DB::table('users')
                ->where('id', $id)
                ->first();
        return view('back.system.users_edit', compact('user'));
        }else{return view('back.home');}
    }

    public function users_edit_post(Request $request, $id){
        
        $update=DB::table('users')->where('id',$id)->update([
            'status'=>$request['status'],
            
            'updated_at'=>now()
        ]);
        if($update){
            return redirect()->route('users');
        }
    
}
}
