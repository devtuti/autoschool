<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\TestAnswer;

class TestAnswerController extends Controller
{
    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }
    public function test_answer(){
        $answers= TestAnswer::paginate(10);
        return view('back.system.test_answer_list',compact('answers'));
    }

    public function test_answer_add(){
        $questions = DB::table('test_questions')->get();
        return view('back.system.test_answer_insert', compact('questions'));
    }

    public function test_answer_post(Request $request){
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
                    'a_id'=>1,
                    't_q_id'=>$request->question,
                    'answer'=>$request->answer[$item],
                    'correct_answer'=>$request->correct[$item],
                    'created_at'=>now()
                );
                TestAnswer::insert($data);
            }
            return redirect()->route('test_answers');
        }
        
    }

    public function test_answer_edit($id){
        $answer = DB::table('test_answers')
                ->where('id', $id)
                ->first();
        $questions = DB::table('test_questions')->get();
        return view('back.system.test_answer_edit', compact('answer', 'questions'));
    }

    public function test_answer_update(Request $request, $id){
        $validation = [
            'answer'=> 'required | min:5',

        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            $update=DB::table('test_answers')->where('id',$id)->update([
                't_q_id'=>$request['question'],
                'answer'=>$request['answer'],
                'correct_answer'=>$request['correct'],
                'updated_at'=>now()
            ]);
            if($update){
                return redirect()->route('test_answers');
            }
        }
    }

    public function test_answer_delete($id){
        TestAnswer::find($id)->delete();
        return redirect()->back();
    }

    public function test_answer_trashed(){
        $answers = TestAnswer::onlyTrashed()
                ->join('test_questions', 'test_questions.id', 'test_answers.t_q_id')
                ->select('test_answers.*', 'test_questions.*', 'test_answers.id as an_id')
                ->paginate(10); 
        return view('back.system.test_answer_trashed', compact('answers'));
    }

    public function test_answer_restore($id){
        TestAnswer::onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    public function test_answer_destroy($id){
        TestAnswer::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back();
    }

    public function test_answer_alldelete(Request $request){
        $check = $request->answer_id;
        TestAnswer::whereIn('id',$check)->delete();
        return redirect()->back();
    }

    public function test_answer_trashed_delete(Request $request){
        $check = $request->answer_id;
        TestAnswer::onlyTrashed()->whereIn('id',$check)->forceDelete();
        return redirect()->back();
    }
}
