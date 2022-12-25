<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\GroupUsers;
use App\Models\Jurnal;
use Illuminate\Support\Facades\Auth;
use App\Models\Test_User_Answer;
use App\Models\User_resultats;
use App\Models\Share;
use App\Models\Comment;
use App\Models\User;
use App\Models\Likes;
use Illuminate\Support\Facades\Validator;
use File;

class HomeController extends Controller
{

    public function __construct(){
        view()->share("groups", GroupUsers::all());
        view()->share("jurnal", Jurnal::all());
        view()->share("categories", Category::where('sub_id', 0)->where('status','1')->with('children')->get());
    }

    public function index(){
        $user_id = Auth::user()->id;
      
        $last_test = DB::table('user_resultats')
                    ->join('categories','categories.id','=','user_resultats.cat_id')
                    ->select('user_resultats.*','categories.id','categories.cat_name')
                    ->where('user_id',$user_id)
                    ->orderBy('user_resultats.created_at','desc')
                    ->limit(1)
                    ->first();
        $hit = DB::table('user_resultats')
                ->join('categories','categories.id','=','user_resultats.cat_id')
                ->join('users','users.id','=','user_resultats.user_id')
                ->select('user_resultats.*','categories.id','categories.cat_name','users.name','user_resultats.created_at as test_date')
                ->orderBy('correct_percent','desc')
                ->limit(10)
                ->get();
        $teachers = DB::table('admins')
                    ->where('grade','=','2')
                    ->where('status','=','1')
                    ->get();
   
      /*  Suallari category gore qruplayib sayi 100%.
        hemin category gore qruplanmiw test_questions id beraber olmalidi test_user_answer.question_id ve user_id=giren usere
        ordan cixan answer_id beraber olmalidi test_answers.a_id 
        where test_answers.correct_answer=1
    */
        return view('front.home', compact('teachers','last_test','hit'));
    }



    public function share(Request $request){
        if(!empty($request->share_photo) and !empty($request->share_post) and isset($request->teacher)){
            if($request->hasFile('share_photo')){
                $file = $request->file('share_photo');
                $file_name = time().'-'.$file->getClientOriginalName();
                $upload = $file->move(public_path().'/shares',$file_name);
                if($upload){
                    Shares::insert([
                        'content_text'=>$request->share_post,
                        'photo'=>$file_name,
                        'user_id'=>Auth::user()->id,
                        'privacy'=>$request->teacher,
                        'created_at'=>now()
                    ]);
                    return response()->json(['code'=>1,'msg'=>'<button type="button" class="btn btn-success toastrDefaultSuccess">
                    New share post has been saved successfuly
                  </button>']);
                }
            }
        }elseif(!empty($request->share_photo) and isset($request->teacher) and empty($request->share_post)){
            if($request->hasFile('share_photo')){
                $file = $request->file('share_photo');
                $file_name = time().'-'.$file->getClientOriginalName();
                $upload = $file->move(public_path().'/shares',$file_name);
                if($upload){
                    Shares::insert([
                        'photo'=>$file_name,
                        'user_id'=>Auth::user()->id,
                        'privacy'=>$request->teacher,
                        'created_at'=>now()
                    ]);
                    return response()->json(['code'=>1,'msg'=>'<button type="button" class="btn btn-success toastrDefaultSuccess">
                    New share post has been saved successfuly
                  </button>']);
                }
            }
        }elseif(empty($request->share_photo) and isset($request->teacher) and !empty($request->share_post)){
            Shares::insert([
                'content_text'=>$request->share_post,
                'user_id'=>Auth::user()->id,
                'privacy'=>$request->teacher,
                'created_at'=>now()
            ]);
            return response()->json(['code'=>1,'msg'=>'<button type="button" class="btn btn-success toastrDefaultSuccess">
            New share post has been saved successfuly
          </button>']);
        }elseif(!empty($request->share_photo) and !isset($request->teacher) and empty($request->share_post)){
            if($request->hasFile('share_photo')){
                $file = $request->file('share_photo');
                $file_name = time().'-'.$file->getClientOriginalName();
                $upload = $file->move(public_path().'/shares',$file_name);
                if($upload){
                    Shares::insert([
                        'photo'=>$file_name,
                        'user_id'=>Auth::user()->id,
                        'created_at'=>now()
                    ]);
                    return response()->json(['code'=>1,'msg'=>'<button type="button" class="btn btn-success toastrDefaultSuccess">
                    New share post has been saved successfuly
                  </button>']);
                }
            }
        }elseif(empty($request->share_photo) and !isset($request->teacher) and !empty($request->share_post)){
            Shares::insert([
                'content_text'=>$request->share_post,
                'user_id'=>Auth::user()->id,
                'created_at'=>now()
            ]);
            return response()->json(['code'=>1,'msg'=>'<button type="button" class="btn btn-success toastrDefaultSuccess">
            New share post has been saved successfuly
          </button>']);
        }
        
    }

    public function shares(){
        $user_id = Auth::user()->id;
        $data['share'] = Share::with('user')->with('comment')->with('like_share')->get();
        $data['comment'] = Comment::where('sub_comment_id','=','0')->with('children')->get();
        
        /*$data['share_like'] = DB::table('likes')
                                ->join('shares','shares.id','=','likes.share_id')
                                ->select(DB::raw('sum(likes.liked) as share_like'))
                                ->groupBy('likes.share_id')
                                ->get();
       /* $data['posts'] = DB::table('shares')
                    ->join('users','users.id','=','shares.user_id')
                    ->select('users.name','users.id', 'users.photo','shares.*', 'users.photo as u_photo','shares.created_at as sh_date','shares.id as sh_id')
                    ->groupBy('shares.id')
                    ->orderBy('shares.created_at','desc')
                    ->get();
        $data['comments'] = DB::table('comments')
                            ->where('sub_comment_id','=','0')
                            ->orderBy('created_at','desc')
                            ->get();
        $data['comments_for_comment'] = DB::table('comments')
                            ->where('sub_comment_id','>','0')
                            ->orderBy('created_at','desc')
                            ->get();
        $data['count_comment'] = DB::table('comments')
                                ->join('shares','shares.id','=','comments.share_id')
                                ->select('shares.id','comments.share_id',DB::raw('count(comments.share_id) as count_com'))
                                ->groupBy('shares.id')
                                ->get();
        $data['count_comment_subcomment'] = DB::table('comments')
                               // ->join('shares','shares.id','=','comments.share_id')
                                ->select('comments.sub_comment_id',DB::raw('count(comments.sub_comment_id) as count_subcom'))
                                ->where('sub_comment_id','>','0')
                                ->groupBy('comments.sub_comment_id')
                                ->get();*/
        return response()->json($data);


       /* $shares = DB::table('shares')
                    ->join('users','users.id','=','shares.user_id')
                    ->select('users.name','users.id', 'users.photo','shares.*', 'users.photo as u_photo','shares.created_at as sh_date','shares.id as sh_id')
                    ->where('user_id', Auth::user()->id)
                    ->orderBy('shares.created_at','desc')
                    ->get();
        $data = \View::make('front.all_shares')->with('shares',$shares)->render();
        return response()->json(['code'=>1,'result'=>data]);*/
    }

    public function category($slug){

        $cat = DB::table('categories')->where('slug','=',$slug)->first();
        $lessons = DB::table('lessons')
                    ->join('categories', 'categories.id', '=', 'lessons.cat_id')
                    ->where('lessons.cat_id','=', $cat->id)
                    ->where('lessons.status', '=', '1')
                    ->select('categories.*','lessons.*', 'lessons.slug as l_slug')
                    ->get();
        return view('front.lesson', compact('lessons'));
    }
    public function lesson($slug){
        $lesson = DB::table('lessons')->where('slug','=',$slug)->first();
        return view('front.lesson_single', compact('lesson'));
    }

    public function test($id){
        $tests = DB::table('test_questions')
                ->join('categories','categories.id','=','test_questions.cat_id')
                ->where('test_questions.cat_id', '=', $id)
                ->where('test_questions.staus', '=', '1')
                ->select('test_questions.*', 'test_questions.id as q_id')
                ->get();
        $count_test = DB::table('test_questions')->where('staus','1')->where('cat_id',$id)->get()->count();
        
        return view('front.test', compact('tests','count_test','id'));
    }

    public function test_user(Request $request){
    
            foreach($request->question as $item=>$v){ 
                    $data=array(
                        'user_id'=>$request->user,
                        'question_id'=>$request->question[$item],
                        'answer'=>$request->answer[$item],
                        'created_at'=>now()
                    ); 
                        $delete = Test_User_Answer::where('question_id',$request->question[$item])->where('user_id',$request->user)->delete();
                        Test_User_Answer::insert($data); //dd($data);

                        $correct_count = DB::table('test_user_answers')
                                ->join('test_questions','test_questions.id','=','test_user_answers.question_id')
                                ->where('test_user_answers.question_id','=',$request->question[$item])
                                ->where('test_user_answers.user_id','=',$request->user)
                                ->groupBy('test_questions.cat_id')
                                ->get();
                        $count =count($correct_count);
                        $test_count = DB::table('test_questions')
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
            User_resultats::insert($data2);

        return redirect()->route('home');
        
    }


    public function about(){
        return view('front.about');
    }
}
