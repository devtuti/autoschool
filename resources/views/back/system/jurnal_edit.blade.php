@extends('layouts.back')
@section('title')
     Update jurnal
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Jurnal edit</h4>
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
                  <form action="{{route('jurnal_edit_post', $jurnal->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                  <div class="row">
                      
                  <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Groups</label>
                          <select name="group" class="form-control">
                              @foreach($groups as $group)
                                @if($group->id == $jurnal->group_id)
                                    <option value="{{$group->id}}" selected>{{$group->group_name}}</option>
                                @else
                                    <option value="{{$group->id}}">{{$group->group_name}}</option>
                                @endif
                              @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Categories</label>
                          <select name="category" class="form-control">
                              @foreach($categories as $cat)
                                @if($cat->id == $jurnal->group_id)
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

                             
                    <button type="submit" class="btn btn-primary pull-right">Update jurnal</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection