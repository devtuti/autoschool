<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\GroupUsers;

class GroupUserController extends Controller
{
    public function __construct(){
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());
    }
    function group_users(){
        if(Auth::guard('admin')->user()->grade==2){
        $group_users = DB::table('group_user')
                        ->join('users', 'users.id', '=', 'group_user.user_id')
                        ->join('groups', 'groups.id', '=', 'group_user.group_id')
                        ->select('group_user.*', 'users.*', 'groups.*', 'group_user.id as g_id')
                        ->where('group_admin', '=', Auth::guard('admin')->user()->id)
                        ->get();
        return view('back.system.group_user', compact('group_users'));
        }else{return view('back.home');}
    }

    function group_user_add(){
        if(Auth::guard('admin')->user()->grade==2){
            $users = DB::table('users')->where('teacher_id', '=', Auth::guard('admin')->user()->id)->get();
            $groups = DB::table('groups')->where('teacher_id', '=', Auth::guard('admin')->user()->id)->where('status', '=', '1')->get();
            return view('back.system.group_user_insert', compact('users', 'groups'));
        }else{return view('back.home');}
    }

    function group_user_post(Request $request){
        //dd($request->all());
        $groups = DB::table('groups')->get();
        foreach($groups as $group){
            if($group->status==1){
                if(Auth::guard('admin')->user()->grade==2){
                    foreach($request->user_name as $item=>$v){
                        $data=array(
                            'group_id'=>$request->group[$item],
                            'user_id'=>$request->user_name[$item],
                            'group_admin'=>Auth::guard('admin')->user()->id,
                            'created_at'=>now()
                        );
                        $users = DB::table('group_user')->get();
                        foreach($users as $user){
                            if($user->user_id == $request->user_name[$item]){
                                return redirect()->route('group_insert_user')->withErrors('tekrar istifadeci qrupa daxil etmek olmaz');
                            }else{
                                GroupUsers::insert($data);
                            }
                        }
                        
                    }
                    return redirect()->route('group_users');
                }else{return view('back.home');}
            }
        }
        
    }

    function group_user_edit($id){
        if(Auth::guard('admin')->user()->grade==2){
        $group_user = DB::table('group_user')
                ->where('id', $id)
                ->first();
        $users = DB::table('users')->where('teacher_id', '=', Auth::guard('admin')->user()->id)->get();
        $groups = DB::table('groups')->where('teacher_id', '=', Auth::guard('admin')->user()->id)->get();
        return view('back.system.group_user_edit', compact('group_user', 'users', 'groups'));
        }else{return view('back.home');}
    }

    function group_user_update(Request $request){
        if(Auth::guard('admin')->user()->grade==2){
        foreach($request->user_name as $item=>$v){
            $users = DB::table('group_user')->get();
            foreach($users as $user){
                if($user->user_id == $request->user_name[$item]){
                    return redirect()->route('group_insert_user')->withErrors('tekrar istifadeci qrupa daxil etmek olmaz');
                }else{
                    DB::table('group_user')
                                ->update([
                                    'group_id' => $request->group_name,
                                    'user_id' => $request->user_name[$item],
                                    'updated_at' => now()
                                ]);

                        return redirect()->route('groups');
                }
            }
        }
    }else{return view('back.home');}
    }

    public function group_user_delete($id){
        if(Auth::guard('admin')->user()->grade==2){
        GroupUsers::find($id)->delete();
        return redirect()->back();
        }else{return view('back.home');}
    }
}
