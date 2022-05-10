<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\TestAnswer;

class ExamAnswerController extends Controller
{
    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }
    public function exam_answer(){
        $answers= ExamAnswer::paginate(10);
        return view('back.system.exam_answer_list',compact('answers'));
    }

    public function exam_answer_add(){
        $questions = DB::table('exam_questions')->get();
        return view('back.system.exam_answer_insert', compact('questions'));
    }

    public function exam_answer_post(Request $request){
        $validation = [
            'answer'=> 'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            foreach($request->answer as $item=>$v){
                $data=array(
                    'e_q_id'=>$request->question,
                    'answer'=>$request->answer[$item],
                    'correct_answer'=>$request->correct[$item],
                    'created_at'=>now()
                );
                ExamAnswer::insert($data);
            }
            return redirect()->route('exam_answers');
        }
        
    }

    public function exam_answer_edit($id){
        $answer = DB::table('exam_answers')
                ->where('id', $id)
                ->first();
        $questions = DB::table('exam_questions')->get();
        return view('back.system.exam_answer_edit', compact('answer', 'questions'));
    }

    public function exam_answer_update(Request $request, $id){
        $validation = [
            'answer'=> 'required | min:5',

        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            $update=DB::table('exam_answers')->where('id',$id)->update([
                'e_q_id'=>$request['question'],
                'answer'=>$request['answer'],
                'correct_answer'=>$request['correct'],
                'updated_at'=>now()
            ]);
            if($update){
                return redirect()->route('exam_answers');
            }
        }
    }

    public function exam_answer_delete($id){
        ExamAnswer::find($id)->delete();
        return redirect()->back();
    }

    public function exam_answer_trashed(){
        $answers = ExamAnswer::onlyTrashed()
                ->join('exam_questions', 'exam_questions.id', 'exam_answers.e_q_id')
                ->select('exam_answers.*', 'exam_questions.*', 'exam_answers.id as e_id')
                ->paginate(10); 
        return view('back.system.exam_answer_trashed', compact('answers'));
    }

    public function exam_answer_restore($id){
        ExamAnswer::onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    public function exam_answer_destroy($id){
        ExamAnswer::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back();
    }

    public function exam_answer_alldelete(Request $request){
        $check = $request->answer_id;
        ExamAnswer::whereIn('id',$check)->delete();
        return redirect()->back();
    }

    public function exam_answer_trashed_delete(Request $request){
        $check = $request->answer_id;
        ExamAnswer::onlyTrashed()->whereIn('id',$check)->forceDelete();
        return redirect()->back();
    }

}
