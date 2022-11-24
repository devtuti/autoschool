<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\KursQuestion;
use File;

class KursQuestionController extends Controller
{
    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }
    public function kurs_question(){
        //$questions= TestQuestion::paginate(10);
        $questions = DB::table('kurs_questions')
                    ->join('kurs_categories', 'kurs_questions.cat_id', '=', 'kurs_categories.id')
                    ->select('kurs_questions.*', 'kurs_categories.*', 'kurs_questions.id as t_q_id')
                    ->paginate(10);
        return view('back.kurs.kurs_question_list',compact('questions'));
    }

    public function kurs_question_add(){
        $categories = DB::table('kurs_categories')->where('sub_id', '>', 0)->where('status','1')->get();
        return view('back.kurs.kurs_question_insert', compact('categories'));
    }

    public function kurs_question_post(Request $request){
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
                                    
                                    $file->move(public_path().'/kurstests',$name);
                                    $data=array(
                                        'question_name'=>$request->q_name,
                                        'slug'=>Str::of($request->q_name)->slug('-'),
                                        'cat_id'=>$request->category,
                                        'question'=>'',
                                        'variant_count'=>$request->variant_count,
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
                                    'variant_count'=>$request->variant_count,
                                    'correct_answer'=>$request->variant,
                                    'staus'=>$request->status,
                                    'photo'=>'',
                                    'created_at'=>now()
                                );
                            }
                            KursQuestion::insert($data);
                            return redirect()->route('kurs_question');
                        //}
         }
           
    }

    public function kurs_question_edit($id){
        $question = DB::table('kurs_questions')
                ->where('id', $id)
                ->first();
        $categories = DB::table('kurs_categories')->where('sub_id', '>', 0)->where('status','1')->get();
        return view('back.kurs.kurs_question_edit', compact('question', 'categories'));
    }

    public function kurs_question_update(Request $request, $id){
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
                    $update=DB::table('kurs_questions')->where('id',$id)->update([
                        'question_name'=>$request['q_name'],
                        'slug'=>Str::of($request['q_name'])->slug('-'),
                        'cat_id'=>$request['category'],
                        'staus'=>$request['status'],
                        'question'=>$request['con_text'],
                        'correct_answer'=>$request['variant'],
                        'variant_count'=>$request['variant_count'],
                        'photo' =>'',
                        'updated_at'=>now()
                    ]);
                }elseif(empty($request->file('photo'))){
                    $photo = KursQuestion::findOrFail($id);
                    if(File::exists("kurstests/".$photo->photo)){
                        File::delete("kurstests/".$photo->photo);
                    }

                    if($request->hasFile('photo')){
                        $file = $request->file('photo');
                        
                        $name = $file->getClientOriginalName();
                        $name = time().'.'.$file->getClientOriginalName();

                        $file->move(public_path().'/kurstests',$name);
                        $update=DB::table('kurs_questions')->where('id',$id)->update([
                            'question_name'=>$request['q_name'],
                            'slug'=>Str::of($request['q_name'])->slug('-'),
                            'cat_id'=>$request['category'],
                            'staus'=>$request['status'],
                            'question'=>'',
                            'correct_answer'=>$request['variant'],
                            'variant_count'=>$request['variant_count'],
                            'photo' =>$name,
                            'updated_at'=>now()
                        ]);
                    }
                    if($update){
                        return redirect()->route('kurs_question');
                    }
                }
        }
    }

    public function kurs_question_delete($id){
        KursQuestion::find($id)->delete();
        return redirect()->back();
    }

    public function kurs_question_trashed(){
        $questions = KursQuestion::onlyTrashed()
                ->join('kurs_categories', 'kurs_categories.id', 'kurs_questions.cat_id')
                ->select('kurs_categories.*', 'kurs_questions.*', 'kurs_questions.id as t_id')
                ->paginate(10); 
        return view('back.kurs.kurs_question_trashed', compact('questions'));
    }

    public function kurs_question_restore($id){
        KursQuestion::onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    public function kurs_question_destroy($id){
        $photo = KursQuestion::onlyTrashed()->find($id);
            if(File::exists("kurstests/".$photo->photo)){
                File::delete("kurstests/".$photo->photo);
            }
        $photo->forceDelete();
        return redirect()->back();
    }

    public function kurs_question_alldelete(Request $request){
        $check = $request->question_id;
        KursQuestion::whereIn('id',$check)->delete();
        return redirect()->back();
    }

    public function kurs_question_trashed_delete(Request $request){
        $check = $request->question_id;
        $ce = KursQuestion::onlyTrashed()->whereIn('id',$check);
        foreach($ce as $c)
            if(File::exists("kurstests/".$c->photo)){
                File::delete("kurstests/".$c->photo);
            }

        $ce->forceDelete();
        
        return redirect()->back();
    }
}
