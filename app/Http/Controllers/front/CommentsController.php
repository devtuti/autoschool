<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\GroupUsers;
use App\Models\Jurnal;
use App\Models\Comments;
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
            'share_id'=>$request->sh_id,
            'share_comment'=>$request->sh_for_comment,
            'created_at'=>now()
        ); 
        $result = Comments::insert($data);
        return response()->json($result);
    }
}
