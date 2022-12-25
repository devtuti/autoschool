<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\GroupUsers;
use App\Models\Jurnal;

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
}
