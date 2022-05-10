@extends('layouts.back')
@section('title')
     Update exam answer
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Answer edit</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">
                @if($errors->any())
                  @foreach($errors->all() as $error)
                  <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b> Owibka - </b> {{$error}}</span>
                  </div>
                  @endforeach
                @endif
                  <form action="{{route('exam_answer_edit_post', $answer->id)}}" method="post">
                    @csrf
                  <div class="row">
                     
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Questions</label>
                          <select name="question" class="form-control">
                            @foreach($questions as $question)
                                @if($question->id == $answer->t_q_id)
                                    <option value="{{$question->id}}" selected>{{$question->question_name}}</option>
                                @else
                                    <option value="{{$question->id}}">{{$question->question_name}}</option>
                                @endif
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Answer</label>
                          <input type="text" class="form-control" name="answer" value="{{$answer->answer}}">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                        <label class="bmd-label-floating">Correct answer</label>
                        <select id="inputState" class="form-control" name="correct">
                            @if($answer->correct_answer==0)
                                <option selected value="0">Yanliw</option>
                                <option value="1">Dogru</option>
                            @else
                                <option value="0">Yanliw</option>
                                <option selected value="1">Dogru</option>
                            @endif
                        </select>
                        </div>
                      </div>
                      
                    </div>

                    <button type="submit" class="btn btn-primary pull-right">Update answer</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection