<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Kurs;

class KursController extends Controller
{

    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }

    public function kurs(){
        $kurs = DB::table('kurs')
                ->join('admins','admins.id','=','kurs.admin_id')
                ->select('kurs.*','admins.name_familya','kurs.id as k_id','kurs.created_at as k_date')
                ->orderBy('kurs.created_at','desc')
                ->get();
        return view('back.kurs.kurs', compact('kurs'));
    }

    public function kurs_add(){
        return view('back.kurs.kurs_insert');
    }

    public function kurs_insert(Request $request){
        $validation = [
            'kurs_name'=> 'required',
            'kurs_content'=> 'required',
            'price'=> 'required',
            'status'=> 'required',
            
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            if(empty($request->discount)){
                       
                $data=array(
                    'kurs_name'=>$request->kurs_name,
                    'admin_id'=>Auth::guard('admin')->user()->id,
                    'price'=>$request->price,
                    'discount'=>'',
                    'status'=>$request->status,
                    'kurs_content'=>$request->kurs_content,
                    'created_at'=>now()
                ); 
            }else{
                $data=array(
                    'kurs_name'=>$request->kurs_name,
                    'admin_id'=>Auth::guard('admin')->user()->id,
                    'price'=>$request->price,
                    'discount'=>$request->discount,
                    'status'=>$request->status,
                    'kurs_content'=>$request->kurs_content,
                    'created_at'=>now()
                ); 
            }
            Kurs::insert($data);
            return redirect()->route('kurs');
        }
    }

    public function kurs_edit($id){
        $kurs = DB::table('kurs')
                ->where('id', $id)
                ->first();
        
        return view('back.kurs.kurs_edit', compact('kurs'));
    }

    public function kurs_update(Request $request,$id){
        $validation = [
            'status'=> 'required',
            'kurs_content'=>'required',
            
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);

        if($rules->fails()){
            return redirect()->back()->withErrors($rules);
        }else{
            
                    if(empty($request->discount)){
                            DB::table('kurs')
                            ->update([
                                'discount' => '',
                                'status' => $request->status,
                                'kurs_content' => $request->kurs_content,
                                'updated_at' => now()
                            ]);
                    
                    }else{
                        DB::table('kurs')
                            ->update([
                                'discount' => $request->discount,
                                'status' => $request->status,
                                'kurs_content' => $request->kurs_content,
                                'updated_at' => now()
                            ]);
                    }
                 }

        return redirect()->route('kurs');
    }
    
}
