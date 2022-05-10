<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Category;
use App\Models\GroupUsers;
use App\Models\Jurnal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;

class StudentLoginController extends Controller
{
    public function __construct(){
        view()->share("groups", GroupUsers::all());
        view()->share("jurnal", Jurnal::all());
        view()->share("categories", Category::where('sub_id', 0)->where('status','1')->with('children')->get());
    }

    public function login(){
        return view('front.student_login');
    }

    public function studentlogin(Request $request){
        $validation = [
            'username'=> 'required',
            'pass' => 'required',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);
        if($rules->fails()){
            return redirect()->back()->withErrors($rules)->withInput();
        }else{
            if(Auth::attempt(['name'=>$request->username, 'password'=>$request->pass])){
                return redirect()->route('home');
            }
            return redirect()->route('studentlogin')->withErrors('Xeta var');
        }
    }

    public function edit($id){
        $users = DB::table('users')->where('id',$id)->first();
        return view('front.student_edit', compact('users'));
    }

    public function edit_post(Request $request, $id){
        $validation = [
            'username'=> 'required',
            'email'=> 'required|email',
            'pass'=> 'required',
            //'photo'=> 'image|mimes:png,jpg,jpeg',
        ];
        $rules = validator($request->all(), $validation,[
            'min' => ':attribute sahesi minimum :min olmaldir'
        ]);

        if($rules->fails()){
            return redirect()->back()->withErrors($rules);
        }else{
                    $photo = User::findOrFail($id);
                    if(File::exists("users/".$photo->photo)){
                        File::delete("users/".$photo->photo);
                    }

                    if($request->hasFile('photo')){
                        $file = $request->file('photo');
                        
                            $name = $file->getClientOriginalName();
                            $name = time().'.'.$file->getClientOriginalName();

                            $file->move(public_path().'/users',$name);

                            DB::table('users')
                            ->update([
                                'name' => $request->username,
                                'email' => $request->email,
                                'password' => $request->pass,
                                'photo' => $name,
                                'updated_at' => now()
                            ]);

                    }
                    
            
        return redirect()->route('home');
        }
    }

    public function exit(){
        Auth::logout();
        return redirect()->route('studentlogin');
    }
}
