@extends('layouts.back')
@section('title')
     Kurs question to look
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Kurs question to look</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">
           
                  <div class="row">
                      
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Question name</label>
                          <input type="text" class="form-control" disabled value="{{$question->question_name}}">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                        <label class="bmd-label-floating">Variant</label>
                        
                            @if($question->answer==$question->correct_answer)
                                <p style="color:green;">{{$question->answer}}</p>
                            @else
                                <p style="color:red;">{{$question->answer}}</p>
                            @endif
                        </select>
                        </div>
                      </div>
                      
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Sual</label>
                          <div class="form-group">
                            <label class="bmd-label-floating">Cavab verdiyiniz sual..</label>
                            <textarea disabled class="form-control" rows="5">{{$question->question}}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
           
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection