<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Category;
use App\Models\GroupUsers;
use App\Models\Jurnal;
use App\Models\Shares;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;

class StudentLoginController extends Controller
{
    public function __construct(){
        view()->share("groups", GroupUsers::all());
        view()->share("jurnal", Jurnal::all());
        view()->share("categories", Category::where('sub_id', 0)->where('status','1')->with('children')->get());
    }

    public function login(){
        return view('front.student_login');
    }

    public function studentlogin(Request $request){
        $validation = [
            'username'=> 'required',
            'pass' => 'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            if(Auth::attempt(['name'=>$request->username, 'password'=>$request->pass])){
                return redirect()->route('home');
            }
            return redirect()->route('studentlogin')->withErrors('Xeta var');
        }
    }

    public function profile(){
        $users = DB::table('users')->where('id',Auth::user()->id)->first();
        $last_test = DB::table('user_resultats')
                    ->join('categories','categories.id','=','user_resultats.cat_id')
                    ->select('user_resultats.*','categories.id','categories.cat_name')
                    ->where('user_id',Auth::user()->id)
                    ->orderBy('user_resultats.created_at','desc')
                    ->limit(1)
                    ->first();
        $shares = DB::table('shares')
                ->join('users','users.id','=','shares.user_id')
                ->select('users.name','users.id', 'users.photo','shares.*', 'users.photo as u_photo','shares.created_at as sh_date','shares.id as sh_id')
                ->where('user_id',Auth::user()->id)
                ->orderBy('shares.created_at','desc')
                ->get();
        $user_resultats = DB::table('user_resultats')
                        ->join('categories','categories.id','=','user_resultats.cat_id')
                        ->select('user_resultats.*','categories.id','categories.cat_name','user_resultats.id as u_r_id','user_resultats.created_at as date')
                        ->where('user_id',Auth::user()->id)
                        ->orderBy('user_resultats.created_at','desc')
                        ->get();
        $user_answers = DB::table('test_user_answers')
                        ->join('test_questions','test_questions.id','=','test_user_answers.question_id')
                        ->select('test_user_answers.*','test_questions.id','test_questions.question_name','test_questions.correct_answer','test_user_answers.id as t_u_id','test_user_answers.created_at as u_date')
                        ->where('test_user_answers.user_id',Auth::user()->id)
                        ->orderBy('u_date','desc')
                        ->get();
        return view('front.profile', compact('users','last_test','shares','user_resultats','user_answers'));
    }

    public function share(Request $request){
        $id = $request->id;
        $share = DB::table('shares')->where('id',$id)->first();
        return $share->content_text;
    }

    public function share_edit_post(Request $request,$id){
    
            $request->validate([
                'sh_edit' => 'required',
            ]);
            $data = Shares::findOrFail($id)->update([
                'content_text'=>$request->sh_edit,         
                'updated_at' => now()
            ]);
      
            return response()->json($data);
        
        
            
        /*$validation = [
            'content_text'=> 'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        $validator = Validator::make($request->all(), [
            'content_text' =>'required',
        ]);
        if($validator->fails()){
        
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
             DB::table('shares')
                    ->update([
                        'content_text'=>$request->content_text,         
                        'updated_at' => now()
                    ]);
                return response()->json([
                    'status'=>200,
                    'message'=>'Updated',
                ]);
        }*/
    }

    public function share_delete(Request $request){
        $id = $request->id;
        $share = Shares::find($id);
        if(!empty($share->photo)){
            if(File::exists("shares/".$share->photo)){
                File::delete("shares/".$share->photo);
            }
            $share->delete();
        }else{
            $share->delete();
        }
        
        return response()->json(['success'=>'Record has been deeted']);
    }

    public function share_photo_delete(Request $request){
        $id = $request->id;
        $share = Shares::find($id);
        if(empty($share->content_text)){
            if(File::exists("shares/".$share->photo)){
                File::delete("shares/".$share->photo);
            }
            $share->delete();
        }else{
            if(File::exists("shares/".$share->photo)){
                File::delete("shares/".$share->photo);
            }
        }
        
        return response()->json(['success'=>'Record has been deeted']);
    }

    public function user_question(Request $request){
        $id = $request->id;
        $question = DB::table('test_user_answers')
                    ->join('test_questions','test_questions.id','=','test_user_answers.question_id')
                    ->select('test_user_answers.*','test_questions.*','test_user_answers.created_at as u_date')
                    ->where('test_user_answers.question_id',$id)
                    ->first();
        return '
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">'.$question->question_name.'</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span>'.$question->u_date.'</span>
            <p>'.$question->question.'</p>
            <img src="'.asset("tests/".$question->photo).'" width="100px" height="100px">
            <p>Sizin cavabiniz - '.$question->answer.'</p>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            
          </div>
        </div>
      </div>
        ';
    }

    public function edit($id){
        $users = DB::table('users')->where('id',$id)->first();
        return view('front.student_edit', compact('users'));
    }

    public function edit_post(Request $request, $id){
        $validation = [
            'username'=> 'required',
            'email'=> 'required|email',
            'pass'=> 'required',
            //'photo'=> 'image|mimes:png,jpg,jpeg',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);

        if($rules->fails()){
            return redirect()->back()->withErrors($rules);
        }else{
                    $photo = User::findOrFail($id);
                    if(File::exists("users/".$photo->photo)){
                        File::delete("users/".$photo->photo);
                    }

                    if($request->hasFile('photo')){
                        $file = $request->file('photo');
                        
                            $name = $file->getClientOriginalName();
                            $name = time().'.'.$file->getClientOriginalName();

                            $file->move(public_path().'/users',$name);

                            DB::table('users')
                            ->update([
                                'name' => $request->username,
                                'email' => $request->email,
                                'password' => $request->pass,
                                'photo' => $name,
                                'updated_at' => now()
                            ]);

                    }
                    
            
        return redirect()->route('home');
        }
    }

    public function exit(){
        Auth::logout();
        return redirect()->route('studentlogin');
    }
}
