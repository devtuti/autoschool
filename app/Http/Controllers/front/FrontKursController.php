<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\GroupUsers;
use App\Models\Jurnal;
use App\Models\Kurs;
use App\Models\KursCategory;
use App\Models\KursLesson;
use App\Models\Kurs_Like;
use App\Models\Course_Test_User_Answer;
use App\Models\Course_user_resultats;
use App\Models\CourseComments;
use App\Models\Course_Comment_Like;

class FrontKursController extends Controller
{
    public function __construct(){
        view()->share("groups", GroupUsers::all());
        view()->share("jurnal", Jurnal::all());
        view()->share("categories", Category::where('sub_id', 0)->where('status','1')->with('children')->get());
    }

    public function kurs(){
        /*$courses = DB::table('kurs')
                ->join('admins', 'admins.id','=','kurs.admin_id')
                ->select('admins.id','admins.name_familya','admins.id as a_id','kurs.*')
                ->whereIn('kurs.id', function ($query) {
                    $query->select('kurs_id')
                    ->from('user_kurs')
                    ->where('user_id', Auth::user()->id );
                })
                ->get();
            */
        $courses = DB::table('kurs')
                    ->join('admins', 'admins.id','=','kurs.admin_id')
                    ->select('admins.id','admins.name_familya','admins.id as a_id','kurs.*')
                    ->get();
        $user_kurs = DB::table('user_kurs')
                    ->select('kurs_id')
                    ->where('user_id', '=', Auth::user()->id)
                    ->get();

   
        for ($i=0; $i < count($courses); $i++) { 
            $course_id = $courses[$i]->id;

            for ($j=0; $j < count($user_kurs); $j++) { 
                $alinanKurs_id = $user_kurs[$j]->kurs_id;
                if($alinanKurs_id == $course_id){
                    $courses[$i]->sold=trim(1);
                }else{
                    $courses[$i]->sold=trim(0);
                } 
            }
            
        }

        //dd($courses);
              
        return view('front.kurs', compact('courses'));
    }

    public function kurs_cats($slug){
        $kurs = Kurs::with('admin')->with('kurscategory')->where('slug',$slug)->get();
        $course_like = DB::table('kurs_liked')->get();
        foreach($kurs as $k){
            $kurs_discount =  ($k->price*$k->discount)/100;
            $kurs_price = $k->price-$kurs_discount;
            return view('front.kurs_content',compact('k','kurs_price','course_like'));
        }

    }

    public function course_like_count(){
        $course_like = DB::table('kurs_liked')->get();
        $course_like_count = count($course_like);
        return response()->json($course_like_count);
    }

    public function kurs_lessons($id){
        $lessons = KursLesson::with('category')->where('cat_id',$id)->where('status','1')->first();
        return view('front.kurs_lesson',compact('lessons'));
    }

    public function course_test_user(Request $request){
    
        foreach($request->question as $item=>$v){ 
                $data=array(
                    'user_id'=>$request->user,
                    'question_id'=>$request->question[$item],
                    'answer'=>$request->answer[$item],
                    'created_at'=>now()
                ); 
                    $delete = Course_Test_User_Answer::where('question_id',$request->question[$item])->where('user_id',$request->user)->delete();
                    Course_Test_User_Answer::insert($data); //dd($data);

                    $correct_count = DB::table('course_test_user_answers')
                            ->join('kurs_questions','kurs_questions.id','=','course_test_user_answers.question_id')
                            ->where('course_test_user_answers.question_id','=',$request->question[$item])
                            ->where('course_test_user_answers.user_id','=',$request->user)
                            ->groupBy('kurs_questions.cat_id')
                            ->get();
                    $count =count($correct_count);
                    $test_count = DB::table('kurs_questions')
                                    ->where('staus','=','1')
                                    ->count();
                    $x = ($count*100)/$test_count;
                    //return $count.'='.$test_count.'='.round($x);
                    $data2=array(
                        'user_id'=>$request->user,
                        'correct_count'=>$count,
                        'correct_percent'=>round($x),
                        'cat_id'=>$request->cat,
                        'created_at'=>now()
                    ); 
        }
        Course_user_resultats::insert($data2);

    return redirect()->route('home');
    
}

    public function kurs_like(Request $request){
        $user_id = Auth::user()->id;
        $data = array(
            'user_id'=>$user_id,
            'kurs_id'=>$request->id,
            'created_at'=>now()
        ); 
        $kurs_like = DB::table('kurs_liked')->get(); 
        if(count($kurs_like)==0){
            $result = Kurs_like::insert($data);
                return response()->json();
        }else{
            foreach($kurs_like as $k_like){
                if($user_id==$k_like->user_id and $request->id==$k_like->kurs_id){
                }else{
                    $result = Kurs_like::insert($data);
                    return response()->json();
                }
            }
        }
        
    }

    public function kurs_test($id){
        $tests = DB::table('kurs_questions')
                ->join('kurs_categories','kurs_categories.id','=','kurs_questions.cat_id')
                ->where('kurs_questions.cat_id', '=', $id)
                ->where('kurs_questions.staus', '=', '1')
                ->select('kurs_questions.*', 'kurs_questions.id as q_id')
                ->get();
        $count_test = DB::table('kurs_questions')->where('staus','1')->where('cat_id',$id)->get()->count();
        
        return view('front.kurs_test', compact('tests','count_test','id'));
    }

    public function course_comments(){
        $user_id = Auth::user()->id;
        $data['comments'] = CourseComments::with('user')->with('course_comment_like')->get();
        return response()->json($data);
    }

    public function course_comment_insert(Request $request){
        $request->validate([
            'com' =>'required',
        ]);

        $data = array(
            'comments'=>$request->com,
            'user_id'=>Auth::user()->id,
            'kurs_id'=>$request->id,
            'created_at'=>now()
        );
        $result =CourseComments::insert($data);
            return response()->json();
    }

    public function course_comment_edit(Request $request){
        $id = $request->id;
        $comments = DB::table('course_comments')->where('id',$id)->first();
        return $comments->comments;
    }

    public function course_comment_update(Request $request, $id){
        $request->validate([
            'com_edit' => 'required',
        ]);
        $data = CourseComments::findOrFail($id)->update([
            'comments'=>$request->com_edit,         
            'updated_at' => now()
        ]);
  
        return response()->json($data);
    
    }

    public function course_comment_delete(Request $request){
        $id = $request->id;
        $comment = CourseComments::find($id);
        $comment->delete();
       
        return response()->json(['success'=>'Comment has been deeted']);
    }

    public function course_comment_like(Request $request){
        $user_id = Auth::user()->id;
        $data = array(
            'user_id'=>$user_id,
            'comment_id'=>$request->id,
            'created_at'=>now()
        ); 
        $kurs_comment_like = DB::table('course_comment_like')->get(); 
        if(count($kurs_comment_like)==0){
            $result = Course_Comment_Like::insert($data);
                return response()->json();
        }else{
            foreach($kurs_comment_like as $k_like){
                if($user_id==$k_like->user_id and $request->id==$k_like->comment_id){
                }else{
                    $result = Course_Comment_Like::insert($data);
                    return response()->json();
                }
            }
        }
        
    }

    }

