<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\KursLesson;
use File;

class KursLessonController extends Controller
{
    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }
    public function kurs_lessons(){
        //$lessons= Lesson::paginate(10);
        $lessons = DB::table('kurs_lessons')
                    ->join('kurs_categories', 'kurs_lessons.cat_id', '=', 'kurs_categories.id')
                    ->select('kurs_lessons.*', 'kurs_categories.*', 'kurs_lessons.id as l_id','kurs_lessons.created_at as l_date','kurs_lessons.updated_at as l_update','kurs_lessons.status as l_status')
                    ->paginate(10);
        return view('back.kurs.kurs_lesson',compact('lessons'));
    }

    public function kurs_lesson_add(){
        $categories = DB::table('kurs_categories')->where('sub_id', '>', 0)->where('status','1')->get();
        return view('back.kurs.kurs_lesson_insert', compact('categories'));
    }

    public function kurs_lesson_post(Request $request){
        $validation = [
            'lesson_name'=> 'required',
            'photo'=>'required',
            'les_video'=>'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
                        if(empty($request->con_text)){
                            if($request->hasFile('photo')){
                                $file = $request->file('photo');
                                $name = $file->getClientOriginalName();
                                $name = time().'.'.$file->getClientOriginalName();
                                
                                $file->move(public_path().'/kurs_lesson',$name);

                                if($request->hasFile('les_video')){
                                    $video = $request->file('les_video');
                                    $video_name = $video->getClientOriginalName();
                                    $video_name = time().'.'.$video->getClientOriginalName();
                                    
                                    $video->move(public_path().'/les_video',$video_name);

                                $data=array(
                                    'lesson_name'=>$request->lesson_name,
                                    'slug'=>Str::of($request->lesson_name)->slug('-'),
                                    'les_video'=>$video_name,
                                    'cat_id'=>$request->category,
                                    'status'=>$request->status,
                                    'content_text'=>'',
                                    'photo'=>$name,
                                    'created_at'=>now()
                                ); //dd($data);
                                }
                            }
                            
                        }else{
                            if($request->hasFile('photo')){
                                $file = $request->file('photo');
                                $name = $file->getClientOriginalName();
                                $name = time().'.'.$file->getClientOriginalName();
                                
                                $file->move(public_path().'/kurs_lesson',$name);

                                if($request->hasFile('les_video')){
                                    $video = $request->file('les_video');
                                    $video_name = $video->getClientOriginalName();
                                    $video_name = time().'.'.$video->getClientOriginalName();
                                    
                                    $video->move(public_path().'/les_video',$video_name);

                                $data=array(
                                    'lesson_name'=>$request->lesson_name,
                                    'slug'=>Str::of($request->lesson_name)->slug('-'),
                                    'les_video'=>$video_name,
                                    'cat_id'=>$request->category,
                                    'status'=>$request->status,
                                    'content_text'=>$request->con_text,
                                    'photo'=>$name,
                                    'created_at'=>now()
                                ); //dd($data);
                                }
                            } 
                        }
                        KursLesson::insert($data);
                        return redirect()->route('kurs_lesson');
            
        }
        
    }

    public function kurs_lesson_edit($id){
        $lesson = DB::table('kurs_lessons')
                ->where('id', $id)
                ->first();
        $categories = DB::table('kurs_categories')->where('sub_id', '>', 0)->where('status','1')->get();
        return view('back.kurs.kurs_lesson_edit', compact('lesson', 'categories'));
    }

    public function kurs_lesson_update(Request $request, $id){
        $validation = [
            'lesson_name'=> 'required',
            'photo'=>'required',
            'les_video'=>'required',
            
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);

        if($rules->fails()){
            return redirect()->back()->withErrors($rules);
        }else{
                    
                    if(empty($request->con_text)){
                           
                        if($request->hasFile('photo')){
                            $photo = KursLesson::findOrFail($id);
                            if(File::exists("kurs_lesson/".$photo->photo)){
                                File::delete("kurs_lesson/".$photo->photo);
                            }
                            $file = $request->file('photo');
                            
                                $name = $file->getClientOriginalName();
                                $name = time().'.'.$file->getClientOriginalName();
            
                                $file->move(public_path().'/kurs_lesson',$name);

                                if($request->hasFile('les_video')){
                                    $video_l = KursLesson::findOrFail($id);
                                    if(File::exists("les_video/".$video_l->les_video)){
                                        File::delete("les_video/".$video_l->les_video);
                                    }

                                    $video = $request->file('les_video');
                                    $video_name = $video->getClientOriginalName();
                                    $video_name = time().'.'.$video->getClientOriginalName();
                                    
                                    $video->move(public_path().'/les_video',$video_name);

                                    DB::table('kurs_lessons')
                                    ->update([
                                        'lesson_name' => $request->lesson_name,
                                        'slug'=>Str::of($request->lesson_name)->slug('-'),
                                        'cat_id' => $request->category,
                                        'les_video'=>$video_name,
                                        'status' => $request->status,
                                        'content_text' => '',
                                        'photo' => $name,
                                        'updated_at' => now()
                                    ]);
                                }
                        }
                    }else{
                        if($request->hasFile('photo')){
                            $photo = KursLesson::findOrFail($id);
                            if(File::exists("kurs_lesson/".$photo->photo)){
                                File::delete("kurs_lesson/".$photo->photo);
                            }
                            $file = $request->file('photo');
                            
                                $name = $file->getClientOriginalName();
                                $name = time().'.'.$file->getClientOriginalName();
            
                                $file->move(public_path().'/kurs_lesson',$name);

                                if($request->hasFile('les_video')){
                                    $video_l = KursLesson::findOrFail($id);
                                    if(File::exists("les_video/".$video_l->les_video)){
                                        File::delete("les_video/".$video_l->les_video);
                                    }

                                    $video = $request->file('les_video');
                                    $video_name = $video->getClientOriginalName();
                                    $video_name = time().'.'.$video->getClientOriginalName();
                                    
                                    $video->move(public_path().'/les_video',$video_name);

                                    DB::table('kurs_lessons')
                                    ->update([
                                        'lesson_name' => $request->lesson_name,
                                        'slug'=>Str::of($request->lesson_name)->slug('-'),
                                        'cat_id' => $request->category,
                                        'les_video'=>$video_name,
                                        'status' => $request->status,
                                        'content_text' => $request->con_text,
                                        'photo' => $name,
                                        'updated_at' => now()
                                    ]);
                                }
                        }
                    }
                 }

        return redirect()->route('kurs_lesson');
        
    }

    public function kurs_lesson_delete($id){
        KursLesson::find($id)->delete();
        return redirect()->back();
    }

    public function kurs_lesson_trashed(){
        $lessons = KursLesson::onlyTrashed()
                ->join('kurs_categories', 'kurs_categories.id', 'kurs_lessons.cat_id')
                ->select('kurs_categories.*', 'kurs_lessons.*', 'kurs_lessons.id as l_id','kurs_lessons.created_at as l_date','kurs_lessons.updated_at as l_update','kurs_lessons.status as l_status')
                ->paginate(10); 
        return view('back.kurs.kurs_lesson_trashed', compact('lessons'));
    }

    public function kurs_lesson_restore($id){
        KursLesson::onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    public function kurs_lesson_destroy($id){
        $photo = KursLesson::onlyTrashed()->find($id);
            if(File::exists("kurs_lesson/".$photo->photo)){
                File::delete("kurs_lesson/".$photo->photo);
            }
        $photo->forceDelete();
        return redirect()->back();
    }

    public function kurs_lesson_alldelete(Request $request){
        $check = $request->lesson_id;
        KursLesson::whereIn('id',$check)->delete();
        return redirect()->back();
    }

    public function kurs_lesson_trashed_delete(Request $request){
        $check = $request->lesson_id;
        $ce = KursLesson::onlyTrashed()->whereIn('id',$check);
        foreach($ce as $c)
            if(File::exists("kurs_lesson/".$c->photo)){
                File::delete("kurs_lesson/".$c->photo);
            }

        $ce->forceDelete();
        return redirect()->back();
    }

}
