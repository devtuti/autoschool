@extends('layouts.back')
@section('title')
     Update admin
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Admin edit</h4>
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
                  <form action="{{route('admins_edit_post', $admin->id)}}" method="post">
                    @csrf
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">User name</label>
                          {{$admin->name_familya}}
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                        <label class="bmd-label-floating">Status</label>
                        <select id="inputState" class="form-control" name="status">
                            @if($admin->status==0)
                                <option selected value="0">Deaktive</option>
                                <option value="1">Active</option>
                            @else
                                <option value="0">Deaktive</option>
                                <option selected value="1">Active</option>
                            @endif
                        </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                        <label class="bmd-label-floating">Grade</label>
                        <select id="inputState" class="form-control" name="grade">
                            @if($admin->grade==0)
                                <option selected value="0">Gozleme</option>
                                <option value="1">Admin</option>
                                <option value="2">Muellim</option>
                            @elseif($admin->grade==1)
                                <option value="0">Gozleme</option>
                                <option selected value="1">Admin</option>
                                <option value="2">Muellim</option>
                                @elseif($admin->grade==2)
                                <option value="0">Gozleme</option>
                                <option value="1">Admin</option>
                                <option selected value="2">Muellim</option>
                                @else
                            @endif
                        </select>
                        </div>
                      </div>
                      
                    </div>
                   
                    <button type="submit" class="btn btn-primary pull-right">Update admin</button>
                    <div class="clearfix"></div>
                    </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection