@extends('layouts.back')
@section('title')
     Update lesson
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Lesson edit</h4>
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
                  <form action="{{route('lesson_edit_post', $lesson->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                  <div class="row">
                      
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Lesson name</label>
                          <input type="text" class="form-control" name="lesson_name" value="{{$lesson->lesson_name}}">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Categories</label>
                          <select name="category" class="form-control">
                              @foreach($categories as $cat)
                                @if($cat->id == $lesson->cat_id)
                                    <option value="{{$cat->id}}" selected>{{$cat->cat_name}}</option>
                                @else
                                    <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                                @endif
                              @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                        <label class="bmd-label-floating">Status</label>
                        <select id="inputState" class="form-control" name="status">
                            @if($lesson->status==0)
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
                          <div class="form-group">
                            <label class="bmd-label-floating"> Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</label>
                            <textarea class="form-control" rows="5" name="con_text">{{$lesson->content_text}}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>

                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="inputGroupFile02" name="photo" value="{{$lesson->photo}}">
                            
                            <img class="img-responsive" style="max-height:50px; max-width:50px;" src="/lessons/{{$lesson->photo}}"> 
                        </div>

                   
                    <button type="submit" class="btn btn-primary pull-right">Update lesson</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection