<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\KursCategory;

class KursCategoryController extends Controller
{
    protected $appends = [
        'getParentsTree'
    ];

    public static function getParentsTree($category, $title=null){
        if($category->sub_id == 0){
            return $title;
        }
        $parent = KursCategory::find($category->sub_id);
        $title = $parent->kcat_name .''. $title;

        return KursCategoryController::getParentsTree($parent, $title);
    }

    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }

    public function kurscategories(){
        
        $categories= KursCategory::join('kurs', 'kurs.id', '=', 'kurs_categories.kurs_id')
                    ->select('kurs_categories.*', 'kurs.id','kurs.kurs_name','kurs_categories.id as k_id','kurs_categories.created_at as k_date','kurs_categories.updated_at as k_u_date','kurs_categories.status as kstatus')
                    ->with('children')->paginate(10);
        return view('back.kurs.kurs_cat_list',compact('categories'));
    }

    public function kurscategory_add(){
        $kurs = DB::table('kurs')->where('status','1')->get();
        $categories = DB::table('kurs_categories')->where('sub_id',0)->get();
        return view('back.kurs.kurs_cat_insert', compact('kurs', 'categories'));
    }

    public function kurscategory_post(Request $request){
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
                    'kcat_name'=>$request->cat_name[$item],
                    'kurs_id'=>$request->kurs[$item],
                    'slug'=>Str::of($request->cat_name[$item])->slug('-'),
                    'sub_id'=>$request->category[$item],
                    'status'=>$request->status[$item],
                    'created_at'=>now()
                ); //dd($data);
                KursCategory::insert($data);
            }
            return redirect()->route('kurs_cat');
        }
        
    }

    public function kurscat_edit($id){
        $kurs = DB::table('kurs')->where('status','1')->get();
        $cats = DB::table('kurs_categories')->where('id',$id)->first();
        $parent = DB::table('kurs_categories')->where('sub_id',0)->get();
        return view('back.kurs.kurs_cat_edit', compact('kurs', 'cats', 'parent'));
    }

    public function kurscat_update(Request $request, $id){
        $validation = [
            'cat_name'=> 'required | min:5',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            $update=DB::table('kurs_categories')->where('id',$id)->update([
                'kcat_name'=>$request['cat_name'],
                'kurs_id'=>$request['kurs'],
                'slug'=>Str::of($request['cat_name'])->slug('-'),
                'sub_id'=>$request['category'],
                'status'=>$request['status'],
                'updated_at'=>now()
            ]);
            if($update){
                return redirect()->route('kurs_cat');
            }
        }
    }

    public function kurscat_delete($id){
        KursCategory::find($id)->delete();
        return redirect()->back();
    }

    public function kurscat_trashed(){
        $categories = KursCategory::join('kurs', 'kurs.id', '=', 'kurs_categories.kurs_id')
                        ->select('kurs_categories.*', 'kurs.id','kurs.kurs_name','kurs_categories.id as k_id','kurs_categories.created_at as k_date','kurs_categories.updated_at as k_u_date','kurs_categories.status as kstatus')
                        ->onlyTrashed()
                        ->with('children')
                        ->paginate(10); 
        return view('back.kurs.kurs_cat_trashed', compact('categories'));
    }

    public function kurscat_restore($id){
        KursCategory::onlyTrashed()->find($id)->restore();
        return redirect()->route('kurs_cat');
    }

    public function kurscat_destroy($id){
        KursCategory::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back();
    }

    public function kurscat_alldelete(Request $request){
        $check = $request->cat_id;
        KursCategory::whereIn('id',$check)->delete();
        return redirect()->back();
    }

    public function kurscat_trashed_delete(Request $request){
        $check = $request->cat_id;
        KursCategory::onlyTrashed()->whereIn('id',$check)->forceDelete();
        return redirect()->back();
    }

}
