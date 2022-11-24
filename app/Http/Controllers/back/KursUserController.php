<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KursUserController extends Controller
{
    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }

    public function kurs_user(){
        $users = DB::table('kurs_user')
                ->join('users','users.id','=','kurs_user.user_id')
                ->join('kurs','kurs.id','=','kurs_user.kurs_id')
                ->select('kurs_user.*','users.name','users.id','kurs.id','kurs_name','kurs_user.id as kurs_u_id')
                ->orderBy('created_at','desc')
                ->get();
        return view('back.kurs.user_kurs_list',compact('users'));
    }
}
