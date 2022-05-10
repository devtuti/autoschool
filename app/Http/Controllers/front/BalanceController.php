<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Payment;
use App\Models\GroupUsers;
use App\Models\Jurnal;

class BalanceController extends Controller
{
    public function __construct(){
        view()->share("groups", GroupUsers::all());
        view()->share("jurnal", Jurnal::all());
        view()->share("categories", Category::where('sub_id', 0)->where('status','1')->with('children')->get());
    }

    public function balance(){
        $balance = Payment::where('status','=','1')->where('user_id','=',Auth::user()->id)->sum('amount');
        $payments = DB::table('payment')->where('status','=','1')->get();
        //$exams = DB::table('exam_user_answer')->where('user_id','=',Auth::user()->id)->get();
        return view('front.balance', compact('balance', 'payments'));
    }

    public function payment(){
        return view('front.payment');
    }

    public function amount(Request $request){
        $validation = [
            'amount'=> 'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            
                $data=array(
                    'amount'=>$request->amount,
                    'user_id'=>Auth::user()->id,
                    'created_at'=>now()
                );
                Payment::insert($data);
        
            return redirect()->route('balance');
        }
    }
}
