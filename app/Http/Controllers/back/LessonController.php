<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Lesson;
use File;

class LessonController extends Controller
{
    public function lessons(){
        $lessons= Lesson::paginate(10);
        return view('back.system.lesson',compact('lessons'));
    }

    public function lesson_add(){
        $categories = DB::table('categories')->where('sub_id', '>', 0)->get();
        return view('back.system.lesson_insert', compact('categories'));
    }

    public function lesson_post(Request $request){
        $validation = [
            'lesson_name'=> 'required',
            'con_text' => 'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $name = $file->getClientOriginalName();
                $name = time().'.'.$file->getClientOriginalName();
                
                $file->move(public_path().'/lessons',$name);
               
                $data=array(
                    'lesson_name'=>$request->lesson_name,
                    'slug'=>Str::of($request->lesson_name)->slug('-'),
                    'cat_id'=>$request->category,
                    'status'=>$request->status,
                    'content_text'=>$request->con_text,
                    'photo'=>$name,
                    'created_at'=>now()
                ); //dd($data);
                Lesson::insert($data);
                return redirect()->route('lesson');
            }
        }
        
    }

    public function lesson_edit($id){
        $lesson = DB::table('lessons')
                ->where('id', $id)
                ->first();
        $categories = DB::table('categories')->where('sub_id', '>', 0)->get();
        return view('back.system.lesson_edit', compact('lesson', 'categories'));
    }

    public function lesson_update(Request $request, $id){
        $validation = [
            'lesson_name'=> 'required',
            'con_text' => 'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);

        if($rules->fails()){
            return redirect()->back()->withErrors($rules);
        }else{
            $photo = Lesson::findOrFail($id);
            if(File::exists("lessons/".$photo->photo)){
                File::delete("lessons/".$photo->photo);
            }

            if($request->hasFile('photo')){
                $file = $request->file('photo');
                
                    $name = $file->getClientOriginalName();
                    $name = time().'.'.$file->getClientOriginalName();

                    $file->move(public_path().'/lessons',$name);

                    DB::table('lessons')
                    ->update([
                        'lesson_name' => $request->lesson_name,
                        'slug'=>Str::of($request->lesson_name)->slug('-'),
                        'cat_id' => $request->category,
                        'status' => $request->status,
                        'content_text' => $request->con_text,
                        'photo' => $name,
                        'updated_at' => now()
                    ]);

            }
        return redirect()->route('lesson');
        }
    }

    public function lesson_delete($id){
        Lesson::find($id)->delete();
        return redirect()->back();
    }

    public function lesson_trashed(){
        $lessons = Lesson::onlyTrashed()
                ->join('categories', 'categories.id', 'lessons.cat_id')
                ->select('categories.*', 'lessons.*', 'lessons.id as l_id')
                ->paginate(10); 
        return view('back.system.lesson_trashed', compact('lessons'));
    }

    public function lesson_restore($id){
        Lesson::onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    public function lesson_destroy($id){
        $photo = Lesson::onlyTrashed()->find($id);
            if(File::exists("lessons/".$photo->photo)){
                File::delete("lessons/".$photo->photo);
            }
        $photo->forceDelete();
        return redirect()->back();
    }

    public function lesson_alldelete(Request $request){
        $check = $request->lesson_id;
        Lesson::whereIn('id',$check)->delete();
        return redirect()->back();
    }

    public function lesson_trashed_delete(Request $request){
        $check = $request->lesson_id;
        $ce = Lesson::onlyTrashed()->whereIn('id',$check);
        foreach($ce as $c)
            if(File::exists("lessons/".$c->photo)){
                File::delete("lessons/".$c->photo);
            }

        $ce->forceDelete();
        return redirect()->back();
    }

}
