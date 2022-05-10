<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Report;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct(){
        
        view()->share("grade_count", DB::table('admins')->where('grade', '=','0')->count());
        view()->share("user_count", DB::table('users')->where('status', '=','0')->count());

    }

    public function reports(){
        if(request()->from || request()->to){
            $from = Carbon::parse(request()->from)->toDateTimeString();
            $to = Carbon::parse(request()->to)->toDateTimeString();
            $payment = Report::whereBetween('created_at',[$from,$to])->orderBy('created_at','desc')->get();
        }else{
            $payment = DB::table('payment')
            ->join('users', 'users.id','=','payment.user_id')
            ->select('payment.*','users.*', 'payment.id as p_id')
            ->orderBy('payment.created_at','desc')
            ->get();
        }

            $sum = Report::where('status', '1')->sum('amount');
        
        

        return view('back.report', compact('payment','sum'));
    }

   /* public function betweenreports(Request $request){
        $validation = [
            'from'=> 'required',
            'to'=> 'required',
            
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
    
        }else{
            $from = $request->from;
            $to = $request->to;
            $betweenreports = Report::whereBetween('created_at',[$from,$to])->get();
        
            return redirect()->route('reports', compact('betweenreports'));
        }
    }*/
}
