<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Groups;

class GroupController extends Controller
{
    public function __construct(){
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());
    }
    public function groups(){
        if(Auth::guard('admin')->user()->grade==2){
        $groups = DB::table('groups')
        ->join('admins', 'admins.id', 'groups.teacher_id')
        ->select('admins.*', 'groups.*', 'groups.id as g_id')
        ->orderBy('groups.id','desc')
        ->get();
        return view('back.system.group', compact('groups'));
        }else{
            return view('back.home');
        }
    }

    public function group_add(){
        if(Auth::guard('admin')->user()->grade==2){
        return view('back.system.group_insert');
        }else{
            return view('back.home');
        }
    }

    public function group_post(Request $request){
        if(Auth::guard('admin')->user()->grade==2){
        $validation = [
            'group_name'=> 'required',
        
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
           
                $data=array(
                    'group_name'=>$request->group_name,
                    'teacher_id'=>Auth::guard('admin')->user()->id,
                    'status'=>$request->status,
                    'created_at'=>now()
                ); 
                Groups::insert($data);
                return redirect()->route('groups');
            
                
        }
    }else{
        return view('back.home');
    }
        
    }

    public function group_edit($id){
        if(Auth::guard('admin')->user()->grade==2){
        $group = DB::table('groups')
                ->where('id', $id)
                ->first();
        return view('back.system.group_edit', compact('group'));
        }else{
            return view('back.home');
        }
    }

    public function group_update(Request $request, $id){
        if(Auth::guard('admin')->user()->grade==2){
        $validation = [
            'group_name'=> 'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);

        if($rules->fails()){
            return redirect()->back()->withErrors($rules);
        }else{
            
                    DB::table('groups')
                    ->update([
                        'group_name' => $request->group_name,
                        'status' => $request->status,
                        'updated_at' => now()
                    ]);

            return redirect()->route('groups');
        }
    }else{
        return view('back.home');
    }
    }

    public function group_delete($id){
        if(Auth::guard('admin')->user()->grade==2){
        $group_user = DB::table('group_user')->count();
        if($group_user==0){
            Groups::find($id)->delete();
            return redirect()->back();
        }else{
            return redirect()->back();
        }
        
        }else{
            return view('back.home');
        } 
    }

}
