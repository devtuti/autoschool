@extends('layouts.back')
@section('title')
     Update user
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">User edit</h4>
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
                  
                  <div class="row">
                  <form action="{{route('users_edit_post', $user->id)}}" method="post">
                    @csrf
                    <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">User</label>
                          <input type="text" class="form-control" name="" value="{{$user->name}}">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                        <label class="bmd-label-floating">Status</label>
                        <select id="inputState" class="form-control" name="status">
                            @if($user->status==0)
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
                   
                    <button type="submit" class="btn btn-primary pull-right">Update user</button>
                    <div class="clearfix"></div>
                    </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection