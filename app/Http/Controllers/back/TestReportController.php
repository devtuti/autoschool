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
        /*$group = DB::table('group_user')
                ->join('users','group_user.user_id','=','users.id')
                ->select('group_user.*','users.*','group_user.id as g_u_id')
                ->where('group_user.group_id','=',$g_name)
                ->get();
        foreach($group as $g){
            $user_id = $g->user_id;*/

            $user_resultats = DB::table('user_resultats')
                                ->join('users','users.id','=','user_resultats.user_id')
                                ->join('categories','categories.id','=','user_resultats.cat_id')
                                ->join('group_user','group_user.user_id','user_resultats.user_id')
                                ->select('user_resultats.*','users.name','categories.cat_name', 'group_user.user_id', 'group_user.group_id', 'user_resultats.created_at as user_r_date')
                                ->where('group_user.group_id','=',$g_name);
                                return response()->json([
                                    'user_resultats'=>$user_resultats
                                    
                                ]);
           // }
            
        
    }

    public function test_kurs_reports(){
        $user_answers = DB::table('user_kurs_answers')
                        ->join('users','users.id', '=','user_kurs_answers.user_id')
                        ->join('kurs_questions','kurs_questions.id','=','user_kurs_answers.question_id')
                        ->select('user_kurs_answers.*','users.id','users.name','kurs_questions.id','kurs_questions.question_name','kurs_questions.correct_answer','user_kurs_answers.id as u_k_a_id')
                        ->orderBy('created_at','desc')
                        ->get();
        return view('back.user_kurs_reports',compact('user_answers'));
    }

    public function kurs_question_look($id){
        $question = DB::table('user_kurs_answers')
                    ->join('kurs_questions','kurs_questions.id','=','user_kurs_answers.question_id')
                    ->select('user_kurs_answers.question_id','user_kurs_answers.answer','kurs_questions.*')
                    ->where('kurs_questions.id','=',$id)
                    ->first();
        return view('back.kurs_question_look',compact('question'));
    }
}
