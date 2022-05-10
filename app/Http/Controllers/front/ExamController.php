<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\TestQuestion;
use App\Models\GroupUsers;
use App\Models\Jurnal;

class ExamController extends Controller
{
    public function __construct(){
        view()->share("groups", GroupUsers::all());
        view()->share("jurnal", Jurnal::all());
        view()->share("categories", Category::where('sub_id', 0)->where('status','1')->with('children')->get());
    }
    public function exam(){
        $questions = DB::table('test_questions')->inRandomOrder()->limit(10)->get();
        return view('front.exam', compact( 'questions'));
    }

    public function exam_post(Request $request){
        $payment = DB::table('payment')->where('user_id', Auth::user()->id)->first();
        $questions = DB::table('test_questions')->inRandomOrder()->limit(10)->get();
        $count_a = DB::table('payment')->where('user_id', Auth::user()->id)->count();
         foreach($questions as $question){
            /* $count = DB::table('test_user_answer')
                        ->where('question_id', '=', $question->id)
                        ->where('user_id', '=', Auth::user()->id)
                        ->count();*///alinmadi
         }
        return view('front.exam', compact('questions', 'payment', 'count_a'));
    }
    public function question(Request $request){
        $id = $request->id;
        $questions_a = DB::table('test_questions')
                    ->join('test_answers', 'test_answers.t_q_id', '=', 'test_questions.id')
                    ->where('test_questions.id' ,'=', $id)
                    ->where('test_questions.staus', '=', '1')
                    ->select('test_questions.*', 'test_answers.*', 'test_answers.id as an_id')
                    ->get();
        
         foreach($questions_a as $question_a){
            /* $input = DB::table('test_user_answer')
                        ->where('question_id', '=', $id)
                        ->where('user_id', '=', Auth::user()->id)
                        ->where('answer_id', '=', $question_a->an_id)
                        ->count();*/
            return $question_a->question. '<br><div class="form-group">
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" id="customRadio1" name="answers" value="'.$question_a->an_id.'">
              <label for="customRadio1" class="custom-control-label">'.$question_a->answer.'</label>
            
                
            
            </div></div>'; 
        }
    }
    
}
