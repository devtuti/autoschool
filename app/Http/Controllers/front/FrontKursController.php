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
        $courses = DB::table('kurs')
                    ->join('admins','admins.id','=','kurs.admin_id')
                    ->where('kurs.status','=','1')
                    ->select('admins.id as a_id','admins.name_familya','kurs.*','kurs.status as k_status','kurs.created_at as k_date','kurs.updated_at as k_update')
                    ->get();
        $user_kurs = DB::table('user_kurs')->get();
        return view('front.kurs',compact('courses','user_kurs'));
    }
}
