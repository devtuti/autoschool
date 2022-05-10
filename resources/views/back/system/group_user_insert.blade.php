
@extends('layouts.back')
@section('title')
     New group user
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">User to Group add</h4>
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
                  <form action="{{route('post_group_user')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Groups</label>
                          <select name="group[]" class="form-control">
                            <option value="" selected>User sec..</option>
                              @foreach($groups as $group)
                                <option value="{{$group->id}}">{{$group->group_name}}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>

<div class="col-md-3">
    <div class="form-group">
      <label class="bmd-label-floating">User name</label><br>
      @foreach($users as $user)
        <input type="checkbox" name="user_name[]" value="{{$user->id}}">{{$user->name}}
      @endforeach
    </div>
</div>
  
</div>

<button type="submit" class="btn btn-primary pull-right">İnsert user to group</button>
<div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')

@endsection