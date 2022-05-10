<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TestReportController extends Controller
{
    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }

    public function user_reports(){
        return view('back.user_reports');
    }

    public function test_reports(){

        $groups = DB::table('groups')
        ->where('teacher_id','=',Auth::guard('admin')->user()->id)
        ->where('status','=','1')
        ->get();

       return view('back.test_reports',compact('groups'));
  
    }

    public function test_report_user(Request $request){
        $g_name = $request->groups;
        $group = DB::table('group_user')
                ->join('users','group_user.user_id','=','users.id')
                ->select('group_user.*','users.*','group_user.id as g_u_id')
                ->where('group_user.group_id','=',$g_name)
                ->get();
        foreach($group as $g){
            $user_id = $g->user_id;

            $user_correct_count = DB::table('test_user_answers')
                ->select('test_user_answers.created_at as user_date',DB::raw('COUNT(question_id) AS user_correct_count'))  // user_id yazilmamalidir countda
                ->join('test_questions', 'test_questions.id', '=', 'test_user_answers.question_id')
                ->where('test_user_answers.user_id', '=', $user_id)
                ->where('test_questions.correct_answer', '=', 'test_user_answers.answer')
                ->groupBy('test_questions.cat_id')
                ->get();
            foreach($user_correct_count as $c){
                $cats = DB::table('categories')->where('id','=',$c->cat_id)->get();
            }
            
            $question_correct_count = DB::table('test_questions')
                            ->select(DB::raw('COUNT(id) AS question_correct_count'))
                            ->groupBy('test_questions.cat_id')
                            ->get();
            foreach($user_correct_count as $u_c_c){
                foreach($question_correct_count as $q_c_c){
                    $u_c =$u_c_c->user_correct_count;
                    $q_c = $q_c_c->question_correct_count;
                    $faiz = ($u_c*100)/$q_c;
                }
            }
            
        }
        return response()->json([
            'group'=>$group
            /*'cats'=>$cats,
            'faiz'=>$faiz,
            'user_correct_count'=>$user_correct_count*/
        ]);
    }
}
