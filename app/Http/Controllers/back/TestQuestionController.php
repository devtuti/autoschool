<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\TestQuestion;

class TestQuestionController extends Controller
{
    public function test_question(){
        $questions= TestQuestion::paginate(10);
        return view('back.system.test_question_list',compact('questions'));
    }

    public function test_question_add(){
        $categories = DB::table('categories')->where('sub_id', '>', 0)->get();
        return view('back.system.test_question_insert', compact('categories'));
    }

    public function test_question_post(Request $request){
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
            foreach($request->q_name as $item=>$v){
                $data=array(
                    'question_name'=>$request->q_name[$item],
                    'slug'=>Str::of($request->q_name[$item])->slug('-'),
                    'cat_id'=>$request->category[$item],
                    'question'=>$request->con_text[$item],
                    'bal'=>$request->bal[$item],
                    'staus'=>$request->status[$item],
                    'created_at'=>now()
                );
                TestQuestion::insert($data);
            }
            return redirect()->route('test_question');
        }
        
    }

    public function test_question_edit($id){
        $question = DB::table('test_questions')
                ->where('id', $id)
                ->first();
        $categories = DB::table('categories')->where('sub_id', '>', 0)->get();
        return view('back.system.test_question_edit', compact('question', 'categories'));
    }

    public function test_question_update(Request $request, $id){
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
            $update=DB::table('test_questions')->where('id',$id)->update([
                'question_name'=>$request['q_name'],
                'slug'=>Str::of($request['q_name'])->slug('-'),
                'cat_id'=>$request['category'],
                'bal'=>$request['bal'],
                'staus'=>$request['status'],
                'question'=>$request['con_text'],
                'updated_at'=>now()
            ]);
            if($update){
                return redirect()->route('test_question');
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
        TestQuestion::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back();
    }

    public function test_question_alldelete(Request $request){
        $check = $request->question_id;
        TestQuestion::whereIn('id',$check)->delete();
        return redirect()->back();
    }

    public function test_question_trashed_delete(Request $request){
        $check = $request->question_id;
        TestQuestion::onlyTrashed()->whereIn('id',$check)->forceDelete();
        return redirect()->back();
    }
}
