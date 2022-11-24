@extends('layouts.back')
@section('title')
     Update kurs question
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Question edit</h4>
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
                  <form action="{{route('kurs_question_edit_post', $question->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                  <div class="row">
                      
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Question name</label>
                          <input type="text" class="form-control" name="q_name" value="{{$question->question_name}}">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Categories</label>
                          <select name="category" class="form-control">
                            @foreach($categories as $cat)
                                @if($cat->id == $question->cat_id)
                                    <option value="{{$cat->id}}" selected>{{$cat->kcat_name}}</option>
                                @else
                                    <option value="{{$cat->id}}">{{$cat->kcat_name}}</option>
                                @endif
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                        <label class="bmd-label-floating">Status</label>
                        <select id="inputState" class="form-control" name="status">
                            @if($question->staus==0)
                                <option selected value="0">Passiv</option>
                                <option value="1">Active</option>
                            @else
                                <option value="0">Passiv</option>
                                <option selected value="1">Active</option>
                            @endif
                        </select>
                        </div>
                      </div>
                      
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Content Text</label>
                          
                            <label class="bmd-label-floating"> Question content...</label>
                            <textarea class="form-control" rows="5" name="con_text">{{$question->question}}</textarea>
                          
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                            <input type="number" name="variant_count" value="{{$question->variant_count}}" >
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                            <input type="number" name="variant" value="{{$question->correct_answer}}" >
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <input type="file" class="form-control" id="inputGroupFile02" name="photo" value="{{$question->photo}}">
                            
                            <img class="img-responsive" style="max-height:50px; max-width:50px;" src="/kurstests/{{$question->photo}}"> 
                          </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Update question</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection