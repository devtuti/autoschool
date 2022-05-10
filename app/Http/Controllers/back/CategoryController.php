<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $appends = [
        'getParentsTree'
    ];

    public static function getParentsTree($category, $title=null){
        if($category->sub_id == 0){
            return $title;
        }
        $parent = Category::find($category->sub_id);
        $title = $parent->cat_name .''. $title;

        return CategoryController::getParentsTree($parent, $title);
    }

    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }

    public function categories(){
        $grade_count = DB::table('admins')->where('grade', '=','0')->count();
        $categories= Category::with('children')->paginate(10);
        return view('back.system.cat_list',compact('grade_count', 'categories'));
    }

    public function category_add(){
        $categories = DB::table('categories')->where('sub_id',0)->get();
        return view('back.system.cat_insert', compact('categories'));
    }

    public function category_post(Request $request){
        $validation = [
            'cat_name'=> 'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            foreach($request->cat_name as $item=>$v){
                $data=array(
                    'cat_name'=>$request->cat_name[$item],
                    'slug'=>Str::of($request->cat_name[$item])->slug('-'),
                    'sub_id'=>$request->category[$item],
                    'status'=>$request->status[$item],
                    'created_at'=>now()
                );
                Category::insert($data);
            }
            return redirect()->route('cat');
        }
        
    }

    public function cat_edit($id){
        $cats = DB::table('categories')->where('id',$id)->first();
        $parent = DB::table('categories')->where('sub_id',0)->get();
        return view('back.system.cat_edit', compact('cats', 'parent'));
    }

    public function cat_update(Request $request, $id){
        $validation = [
            'cat_name'=> 'required | min:5',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            $update=DB::table('categories')->where('id',$id)->update([
                'cat_name'=>$request['cat_name'],
                'slug'=>Str::of($request['cat_name'])->slug('-'),
                'sub_id'=>$request['category'],
                'status'=>$request['status'],
                'updated_at'=>now()
            ]);
            if($update){
                return redirect()->route('cat');
            }
        }
    }

    public function cat_delete($id){
        Category::find($id)->delete();
        return redirect()->back();
    }

    public function cat_trashed(){
        $categories = Category::onlyTrashed()->with('children')->paginate(10); 
        return view('back.system.cat_trashed', compact('categories'));
    }

    public function cat_restore($id){
        Category::onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    public function cat_destroy($id){
        Category::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back();
    }

    public function cat_alldelete(Request $request){
        $check = $request->cat_id;
        Category::whereIn('id',$check)->delete();
        return redirect()->back();
    }

    public function cat_trashed_delete(Request $request){
        $check = $request->cat_id;
        Category::onlyTrashed()->whereIn('id',$check)->forceDelete();
        return redirect()->back();
    }

}
