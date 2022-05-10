<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Jurnal;

class JurnalController extends Controller
{
    public function __construct(){
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());
    }
    function jurnal(){
        if(Auth::guard('admin')->user()->grade==2){
        $jurnals = DB::table('jurnal')
                        ->join('categories', 'categories.id', '=', 'jurnal.cat_id')
                        ->join('groups', 'groups.id', '=', 'jurnal.group_id')
                        ->select('jurnal.*', 'categories.*', 'groups.*', 'jurnal.id as j_id')
                        ->where('groups.teacher_id', '=', Auth::guard('admin')->user()->id)
                        ->where('categories.sub_id', '>', '0')
                        ->get();
        return view('back.system.jurnal', compact('jurnals'));
        }else{return view('back.home');}
    }

    function jurnal_add(){
        if(Auth::guard('admin')->user()->grade==2){
        $categories = DB::table('categories')->where('sub_id', '>', '0')->get();
        $groups = DB::table('groups')->where('teacher_id', '=', Auth::guard('admin')->user()->id)->where('status','=','1')->get();
        return view('back.system.jurnal_insert', compact('categories', 'groups'));
        }else{return view('back.home');}
    }

    function jurnal_post(Request $request){
        $groups = DB::table('groups')->get();
        foreach($groups as $group){
            if($group->status==1){
                if(Auth::guard('admin')->user()->grade==2){
                    $data=array(
                        'group_id'=>$request->group,
                        'cat_id'=>$request->category,
                        'status'=>$request->status,
                        'created_at'=>now()
                    );
                    
                    Jurnal::insert($data);
                    
                    return redirect()->route('jurnal');
                }else{return view('back.home');}
            }
        }
        
    }

    function jurnal_edit($id){
        if(Auth::guard('admin')->user()->grade==2){
        $jurnal = DB::table('jurnal')
                ->where('id', $id)
                ->first();
        $categories = DB::table('categories')->where('sub_id', '>', '0')->get();
        $groups = DB::table('groups')->where('teacher_id', '=', Auth::guard('admin')->user()->id)->get();
        return view('back.system.jurnal_edit', compact('jurnal', 'categories', 'groups'));
        }else{return view('back.home');}
    }

    function jurnal_update(Request $request){
        if(Auth::guard('admin')->user()->grade==2){
                    DB::table('jurnal')
                                ->update([
                                    'group_id' => $request->group,
                                    'cat_id' => $request->category,
                                    'status' => $request->status,
                                    'updated_at' => now()
                                ]);

                        return redirect()->route('jurnal');
                            }else{return view('back.home');}       
    }

    public function jurnal_delete($id){
        if(Auth::guard('admin')->user()->grade==2){
        Jurnal::find($id)->delete();
        return redirect()->back();
        }else{return view('back.home');}
    }
}
