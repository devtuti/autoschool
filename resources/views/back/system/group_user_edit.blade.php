@extends('layouts.back')
@section('title')
     Update user group
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">User Group edit</h4>
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
                  <form action="{{route('group_user_edit_post', $group_user->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                  <div class="row">
                      
                  <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Groups</label>
                          <select name="group" class="form-control">
                              @foreach($groups as $group)
                                @if($group->id == $group_user->group_id)
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
                          <label class="bmd-label-floating">User name</label><br>
                          @foreach($users as $user)
                            @if($group_user->user_id==$user->id)
                                <input type="checkbox" name="user_name[]" checked value="{{$user->id}}">{{$user->name}}
                            @else
                            <input type="checkbox" name="user_name[]" value="{{$user->id}}">{{$user->name}}
                            @endif
                          @endforeach
                        </div>
                      </div>

                    </div>

                             
                    <button type="submit" class="btn btn-primary pull-right">Update user group</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection