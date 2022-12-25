<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\GroupUsers;
use App\Models\Jurnal;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    public function __construct(){
        view()->share("groups", GroupUsers::all());
        view()->share("jurnal", Jurnal::all());
        view()->share("categories", Category::where('sub_id', 0)->where('status','1')->with('children')->get());
    }

    public function share_for_comment(Request $request){
        $user_id = Auth::user()->id;
        $request->validate([
            'sh_for_comment' =>'required',
        ]);

        $data = array(
            'user_id'=>$user_id,
            'share_id'=>$request->id,
            'share_comment'=>$request->sh_for_comment,
            'sub_comment_id'=>0,
            'share_photo'=>0,
            'status'=>1,
            'created_at'=>now()
        ); //dd($data);
        $result = Comment::insert($data);
        return response()->json($result);
    }

    public function comforcom(Request $request, $id){
        $user_id = Auth::user()->id;
        $request->validate([
            'com_new' =>'required',
        ]);

        $data = array(
            'user_id'=>$user_id,
            'share_id'=>$request->share_id,
            'share_comment'=>$request->com_new,
            'sub_comment_id'=>$id,
            'share_photo'=>0,
            'status'=>1,
            'created_at'=>now()
        ); //dd($data);
        $result = Comment::insert($data);
        return response()->json(['code'=>1,'msg'=>'<button type="button" class="btn btn-success toastrDefaultSuccess">
            New comment has been saved successfuly
          </button>']);
    }

    public function comment_child(Request $request){
        $id = $request->id;
        $comment = DB::table('comments')
                    ->where('id',$id)->first();
        $users = DB::table('users')->where('id',$comment->user_id)->first();
        return $users->name;
    }

    public function comforcomchild(Request $request, $id){
        $user_id = Auth::user()->id;
        $request->validate([
            'com_new' =>'required',
        ]);

        $data = array(
            'user_id'=>$user_id,
            'share_id'=>$request->share_id,
            'share_comment'=>$request->com_new,
            'sub_comment_id'=>$id,
            'share_photo'=>0,
            'status'=>1,
            'created_at'=>now()
        ); //dd($data);
        $result = Comment::insert($data);
        return response()->json(['code'=>1,'msg'=>'<button type="button" class="btn btn-success toastrDefaultSuccess">
            New comment has been saved successfuly
          </button>']);
    }

    public function comment(Request $request){
        $id = $request->id;
        $comment = DB::table('comments')->where('id',$id)->first();
        return $comment->share_comment;
    }

    public function com_edit_post(Request $request,$id){
    
        $request->validate([
            'com_edit' => 'required',
        ]);
        $data = Comment::findOrFail($id)->update([
            'share_comment'=>$request->com_edit,         
            'updated_at' => now()
        ]);
  
        return response()->json($data);
    }

   
    public function comchild_edit_post(Request $request,$id){
    
        $request->validate([
            'comchild_edit' => 'required',
        ]);
        $data = Comment::findOrFail($id)->update([
            'share_comment'=>$request->comchild_edit,         
            'updated_at' => now()
        ]);
  
        return response()->json($data);
    }

    public function com_delete(Request $request){
        $id = $request->id;
        $com = Comment::find($id);
        if(!empty($com->share_photo)){
            if(File::exists("comments/".$com->share_photo)){
                File::delete("comments/".$com->share_photo);
            }
            $com->delete();
        }else{
            $com->delete();
        }
        
        return response()->json(['success'=>'Record has been deeted']);
    }

    public function comchild_delete(Request $request){
        $id = $request->id;
        $com = Comment::find($id);
        if(!empty($com->share_photo)){
            if(File::exists("comments/".$com->share_photo)){
                File::delete("comments/".$com->share_photo);
            }
            $com->delete();
        }else{
            $com->delete();
        }
        
        return response()->json(['success'=>'Record has been deeted']);
    }
}
