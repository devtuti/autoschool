<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Share_like;
use App\Models\Comment_like;

class LikesController extends Controller
{
    public function share_like(Request $request){
        $user_id = Auth::user()->id;
        $data = array(
            'user_id'=>$user_id,
            'share_id'=>$request->id,
            'created_at'=>now()
        ); //dd($data);
        $share_like = DB::table('share_like')->get(); 
        if(count($share_like)==0){
            $result = Share_like::insert($data);
                return response()->json(['code'=>1,'msg'=>'<button type="button" class="btn btn-success toastrDefaultSuccess">
                    New like has been saved successfuly
                </button>']);
        }else{
            foreach($share_like as $s_like){
                if($user_id==$s_like->user_id and $request->id==$s_like->share_id){
                }else{
                    $result = Share_like::insert($data);
                    return response()->json(['code'=>1,'msg'=>'<button type="button" class="btn btn-success toastrDefaultSuccess">
                        New like has been saved successfuly
                    </button>']);
                }
            }
        }
        
    }


    public function comment_like(Request $request){
        $user_id = Auth::user()->id;
        $data = array(
            'user_id'=>$user_id,
            'comment_id'=>$request->id,
            'created_at'=>now()
        ); //dd($data);
        $comment_like = DB::table('comment_like')->get(); 
        if(count($comment_like)==0){
            $result = Comment_like::insert($data);
                return response()->json(['code'=>1,'msg'=>'<button type="button" class="btn btn-success toastrDefaultSuccess">
                    New like has been saved successfuly
                </button>']);
        }else{
            foreach($comment_like as $c_like){
                if($user_id==$c_like->user_id and $request->id==$c_like->comment_id){
                }else{
                    $result = Comment_like::insert($data);
                    return response()->json(['code'=>1,'msg'=>'<button type="button" class="btn btn-success toastrDefaultSuccess">
                        New like has been saved successfuly
                    </button>']);
                }
            }
        }
        
    }
}
