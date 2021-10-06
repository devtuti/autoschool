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

    public function categories(){
        $categories= Category::with('children')->get();
        return view('back.cat_list',compact('categories'));
    }

    public function category_add(){
        $categories = DB::table('categories')->where('sub_id',0)->get();
        return view('back.cat_insert', compact('categories'));
    }

    public function category_post(Request $request){
        $validation = [
            'cat_name'=> 'required | min:5',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            $insert=DB::table('categories')->insert([
                'cat_name'=>$request['cat_name'],
                'slug'=>Str::of($request['cat_name'])->slug('-'),
                'sub_id'=>$request['category'],
                'status'=>$request['status'],
                'created_at'=>now()
            ]);
            if($insert){
                return redirect()->route('cat');
            }
        }
        
    }
}
