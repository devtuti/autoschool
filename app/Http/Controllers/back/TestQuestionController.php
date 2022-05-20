<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\TestQuestion;
use File;

class TestQuestionController extends Controller
{
    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }
    public function test_question(){
        //$questions= TestQuestion::paginate(10);
        $questions = DB::table('test_questions')
                    ->join('categories', 'test_questions.cat_id', '=', 'categories.id')
                    ->select('test_questions.*', 'categories.*', 'test_questions.id as t_q_id')
                    ->paginate(10);
        return view('back.system.test_question_list',compact('questions'));
    }

    public function test_question_add(){
        $categories = DB::table('categories')->where('sub_id', '>', 0)->where('status','1')->get();
        return view('back.system.test_question_insert', compact('categories'));
    }

    public function test_question_post(Request $request){
        $validation = [
            'q_name'=> 'required',
            
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
                
                        //foreach($request->q_name as $item=>$v){
                            if(empty($request->con_text)){
                                if($request->hasFile('photo')){
                                    $file = $request->file('photo');
                                    $name = $file->getClientOriginalName();
                                    $name = time().'.'.$file->getClientOriginalName();
                                    
                                    $file->move(public_path().'/tests',$name);
                                    $data=array(
                                        'question_name'=>$request->q_name,
                                        'slug'=>Str::of($request->q_name)->slug('-'),
                                        'cat_id'=>$request->category,
                                        'question'=>'',
                                        'correct_answer'=>$request->variant,
                                        'staus'=>$request->status,
                                        'photo'=>$name,
                                        'created_at'=>now()
                                    );
                                }

                            }elseif(empty($request->file('photo'))){
                                $data=array(
                                    'question_name'=>$request->q_name,
                                    'slug'=>Str::of($request->q_name)->slug('-'),
                                    'cat_id'=>$request->category,
                                    'question'=>$request->con_text,
                                    'correct_answer'=>$request->variant,
                                    'staus'=>$request->status,
                                    'photo'=>'',
                                    'created_at'=>now()
                                );
                            }
                            TestQuestion::insert($data);
                            return redirect()->route('test_question');
                        //}
         }
           
    }

    public function test_question_edit($id){
        $question = DB::table('test_questions')
                ->where('id', $id)
                ->first();
        $categories = DB::table('categories')->where('sub_id', '>', 0)->where('status','1')->get();
        return view('back.system.test_question_edit', compact('question', 'categories'));
    }

    public function test_question_update(Request $request, $id){
        $validation = [
            'q_name'=> 'required | min:5',
            
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            
                if(!empty($request->con_text)){
                    $update=DB::table('test_questions')->where('id',$id)->update([
                        'question_name'=>$request['q_name'],
                        'slug'=>Str::of($request['q_name'])->slug('-'),
                        'cat_id'=>$request['category'],
                        'staus'=>$request['status'],
                        'question'=>$request['con_text'],
                        'correct_answer'=>$request['variant'],
                        'photo' =>'',
                        'updated_at'=>now()
                    ]);
                }elseif(empty($request->file('photo'))){
                    $photo = TestQuestion::findOrFail($id);
                    if(File::exists("lessons/".$photo->photo)){
                        File::delete("lessons/".$photo->photo);
                    }

                    if($request->hasFile('photo')){
                        $file = $request->file('photo');
                        
                        $name = $file->getClientOriginalName();
                        $name = time().'.'.$file->getClientOriginalName();

                        $file->move(public_path().'/lessons',$name);
                        $update=DB::table('test_questions')->where('id',$id)->update([
                            'question_name'=>$request['q_name'],
                            'slug'=>Str::of($request['q_name'])->slug('-'),
                            'cat_id'=>$request['category'],
                            'staus'=>$request['status'],
                            'question'=>'',
                            'correct_answer'=>$request['variant'],
                            'photo' =>$name,
                            'updated_at'=>now()
                        ]);
                    }
                    if($update){
                        return redirect()->route('test_question');
                    }
                }
        }
    }

    public function test_question_delete($id){
        TestQuestion::find($id)->delete();
        return redirect()->back();
    }

    public function test_question_trashed(){
        $questions = TestQuestion::onlyTrashed()
                ->join('categories', 'categories.id', 'test_questions.cat_id')
                ->select('categories.*', 'test_questions.*', 'test_questions.id as t_id')
                ->paginate(10); 
        return view('back.system.test_question_trashed', compact('questions'));
    }

    public function test_question_restore($id){
        TestQuestion::onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    public function test_question_destroy($id){
        $photo = TestQuestion::onlyTrashed()->find($id);
            if(File::exists("lessons/".$photo->photo)){
                File::delete("lessons/".$photo->photo);
            }
        $photo->forceDelete();
        return redirect()->back();
    }

    public function test_question_alldelete(Request $request){
        $check = $request->question_id;
        TestQuestion::whereIn('id',$check)->delete();
        return redirect()->back();
    }

    public function test_question_trashed_delete(Request $request){
        $check = $request->question_id;
        $ce = TestQuestion::onlyTrashed()->whereIn('id',$check);
        foreach($ce as $c)
            if(File::exists("lessons/".$c->photo)){
                File::delete("lessons/".$c->photo);
            }

        $ce->forceDelete();
        
        return redirect()->back();
    }
}
