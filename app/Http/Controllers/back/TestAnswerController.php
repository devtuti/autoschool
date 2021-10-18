<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\TestAnswer;

class TestAnswerController extends Controller
{
    public function test_answer(){
        $answers= TestAnswer::paginate(10);
        return view('back.system.test_answer_list',compact('answers'));
    }
}
