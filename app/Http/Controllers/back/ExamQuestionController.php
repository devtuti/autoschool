<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ExamQuestion;
use File;

class ExamQuestionController extends Controller
{
    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());
    }
    public function exam_question(){
        $questions= ExamQuestion::paginate(10);
        return view('back.system.exam_question_list',compact('questions'));
    }

    public function exam_question_add(){
        $categories = DB::table('car_categories')->where('sub_id', '=', 0)->get();
        return view('back.system.exam_question_insert', compact('categories'));
    }

    public function exam_question_post(Request $request){
        $validation = [
            'q_name'=> 'required',
            'con_text'=> 'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            $categories = DB::table("car_categories")->get();
            foreach($categories as $cat){
                if($cat->status==1){
                    if($request->hasFile('photo')){
                        $file = $request->file('photo');
                       echo $name = $file->getClientOriginalName();
                        /*$name = time().'.'.$file->getClientOriginalName();
                        
                        $file->move(public_path().'/lessons',$name);
                        foreach($request->q_name as $item=>$v){
                            $data=array(
                                'question_name'=>$request->q_name[$item],
                                'slug'=>Str::of($request->q_name[$item])->slug('-'),
                                'cat_id'=>$request->category[$item],
                                'question'=>$request->con_text[$item],
                                'staus'=>$request->status[$item],
                                'photo'=>$name[$item],
                                'created_at'=>now()
                            );
                            ExamQuestion::insert($data);
                        }*/
                    }
                    return redirect()->route('exam_question');
                }else{return redirect()->route('new_exam_question');}
            }
            
        }
        
    }

    public function exam_question_edit($id){
        $question = DB::table('exam_questions')
                ->where('id', $id)
                ->first();
        $categories = DB::table('car_categories')->where('sub_id', '=', 0)->get();
        return view('back.system.exam_question_edit', compact('question', 'categories'));
    }

    public function exam_question_update(Request $request, $id){
        $validation = [
            'q_name'=> 'required | min:5',
            'con_text'=> 'required | min:5',

        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            $photo = ExamQuestion::findOrFail($id);
            if(File::exists("lessons/".$photo->photo)){
                File::delete("lessons/".$photo->photo);
            }

            if($request->hasFile('photo')){
                $file = $request->file('photo');
                
                    $name = $file->getClientOriginalName();
                    $name = time().'.'.$file->getClientOriginalName();

                    $file->move(public_path().'/lessons',$name);
                $update=DB::table('exam_questions')->where('id',$id)->update([
                    'question_name'=>$request['q_name'],
                    'slug'=>Str::of($request['q_name'])->slug('-'),
                    'cat_id'=>$request['category'],
                    'staus'=>$request['status'],
                    'question'=>$request['con_text'],
                    'photo'=>$request['photo'],
                    'updated_at'=>now()
                ]);
                if($update){
                    return redirect()->route('exam_question');
                }
            }
        }
    }

    public function exam_question_delete($id){
        ExamQuestion::find($id)->delete();
        return redirect()->back();
    }

    public function exam_question_trashed(){
        $questions = ExamQuestion::onlyTrashed()
                ->join('car_categories', 'car_categories.id', 'exam_questions.cat_id')
                ->select('car_categories.*', 'exam_questions.*', 'exam_questions.id as e_id')
                ->paginate(10); 
        return view('back.system.exam_question_trashed', compact('questions'));
    }

    public function exam_question_restore($id){
        ExamQuestion::onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    public function exam_question_destroy($id){
        $photo = ExamQuestion::onlyTrashed()->find($id);
            if(File::exists("lessons/".$photo->photo)){
                File::delete("lessons/".$photo->photo);
            }
        $photo->forceDelete();
        
        return redirect()->back();
    }

    public function exam_question_alldelete(Request $request){
        $check = $request->question_id;
        ExamQuestion::whereIn('id',$check)->delete();
        return redirect()->back();
    }

    public function exam_question_trashed_delete(Request $request){
        $check = $request->question_id;
        $ce = ExamQuestion::onlyTrashed()->whereIn('id',$check);
        foreach($ce as $c)
            if(File::exists("lessons/".$c->photo)){
                File::delete("lessons/".$c->photo);
            }

        $ce->forceDelete();
        
        return redirect()->back();
    }
}
