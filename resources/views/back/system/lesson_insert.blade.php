@extends('layouts.back')
@section('title')
     New lesson
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Lesson add</h4>
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
                  <form action="{{route('post_lesson')}}" method="post" enctype="multipart/form-data">
                    @csrf
                  <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Lesson name</label>
                          <input type="text" class="form-control" name="lesson_name">
                        </div>
                    </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Categories</label>
                          <select name="category" class="form-control">
                              @foreach($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                        <label class="bmd-label-floating">Status</label>
                        <select id="inputState" class="form-control" name="status">
                          <option selected value="0">Passiv</option>
                          <option value="1">Active</option>
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
                            <textarea class="form-control" rows="5" name="con_text"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>

                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="inputGroupFile02" name="photo">
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                        </div>

                   
                    <button type="submit" class="btn btn-primary pull-right">İnsert lesson</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')

@endsection