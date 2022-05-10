<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use App\Models\Category;
use App\Models\GroupUsers;
use App\Models\Jurnal;
use App\Models\Mesaj;
use Illuminate\Support\Facades\Auth;

class MesajController extends Controller
{
    public function __construct(){
        view()->share("groups", GroupUsers::all());
        view()->share("jurnal", Jurnal::all());
        view()->share("categories", Category::where('sub_id', 0)->where('status','1')->with('children')->get());
    }

    public function sms(){
        $users = DB::table('users')->where('id','!=',Auth::user()->id)->where('status','1')->get();
        $admins = DB::table('admins')->where('status','1')->where('grade','2')->get();
       
        return view('front.mesaj', compact('users','admins'));
    }

    public function sms_user($id){
        $username = DB::table('users')->where('id','=',$id)->first();
        $teachername = DB::table('admins')->where('id','=',$id)->first();
        $mesajs = DB::table('mesaj')
                ->where('wrote_id','=',Auth::user()->id)
                ->where('to_id','=',$id)
                ->orderBy('created_at','desc')
                ->get();
        return view('front.mesaj_touser',compact('id','username','teachername','mesajs'));
    }

    public function post_sms(Request $request){
        if(empty($request->file('sms_photo'))){
            $data=array(
                'wrote_id'=>Auth::user()->id,
                'to_id'=>$request->touser,
                'sms'=>$request->sms,
                'photo'=>'',
                'status'=>'1',
                'created_at'=>now()
            ); 
            Mesaj::insert($data);
            return redirect()->route('sms');
        }else{
            $file = $request->file('sms_photo');
            $name = $file->getClientOriginalName();
            $name = time().'.'.$file->getClientOriginalName();
        
            $file->move(public_path().'/mesaj',$name);
                       
            $data=array(
                'wrote_id'=>Auth::user()->id,
                'to_id'=>$request->touser,
                'sms'=>$request->sms,
                'photo'=>$name,
                'status'=>'1',
                'created_at'=>now()
            ); //dd($data);
            Mesaj::insert($data);
            return redirect()->route('sms');
        }
                    
    }

    public function sms_edit(Request $request){
        $id = $request->id;
        $mesaj = DB::table('mesaj')->where('id',$id)->first();
        return '
        <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold">Write mesaj</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="'.route("sms.edit.post").'/'.$mesaj->id.'" enctype="multipart/form-data">'
            .csrf_field().
          '<div class="modal-body mx-3">
            <div class="md-form mb-5">
              <input type="file" id="form32" class="form-control validate" value="'.$mesaj->photo.'" name="photo">
              <label data-error="wrong" data-success="right" for="form32">Photo</label>
              <img src="'.asset("mesaj/".$mesaj->photo).'" width="100px" height="100px">
            </div>

            <div class="md-form">
              <textarea type="text" id="form8" class="md-textarea form-control" rows="4" name="sms">'.$mesaj->sms.'</textarea>
              <label data-error="wrong" data-success="right" for="form8">Your message</label>
            </div>

          </div>
          <div class="modal-footer d-flex justify-content-center">
            <button class="btn btn-unique">Send <i class="fas fa-paper-plane-o ml-1"></i></button>
          </div>
        </form>
        </div>
      </div>
      ';
    }

    public function sms_edit_post(Request $request,$id){
        $sms = Mesaj::findOrFail($id);

        $file = $request->file('photo');       
        $name = $file->getClientOriginalName();
        $name = time().'.'.$file->getClientOriginalName();
       

        if(!empty($sms->photo)){
            if(File::exists("mesaj/".$sms->photo)){
                File::delete("mesaj/".$sms->photo);
            }
            $file->move(public_path().'/mesaj',$name);
                    DB::table('mesaj')
                    ->update([
                        'sms' => $request->sms,
                        'photo' => $name,
                        'updated_at' => now()
                    ]);
        }else{
            if(empty($file) and $request->sms){
                DB::table('mesaj')
                        ->update([
                            'sms' => $request->sms,
                            'photo' => '',
                            'updated_at' => now()
                        ]);
            }elseif(empty($request->sms) and $file){
                $file->move(public_path().'/mesaj',$name);
                DB::table('mesaj')
                        ->update([
                            'sms' => '',
                            'photo' => $name,
                            'updated_at' => now()
                        ]);
            }elseif($request->sms and $file){
                $file->move(public_path().'/mesaj',$name);
                DB::table('mesaj')
                        ->update([
                            'sms' => $request->sms,
                            'photo' => $name,
                            'updated_at' => now()
                        ]);
            }elseif(empty($file) and empty($request->sms)){
                return redirect()->back();
            }
        }
            
                    return redirect()->back();
    }

    public function sms_delete($id){
        $sms = Mesaj::find($id);
        if(isset($sms->photo)){
            if(File::exists("mesaj/".$sms->photo)){
                File::delete("mesaj/".$sms->photo);
            }
        }
        $sms->delete();
        return redirect()->back();
    }
}
