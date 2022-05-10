@extends('layouts.back')
@section('title')
    Group User
@endsection
@section('css')
@endsection

@section('page_name')
    Group User list
@endsection

@section('content')
<div class="row">
             
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> </h4>
                  <!--<p class="card-category"> </p>-->
                  
                  <ul class="nav">

                    <li class="nav-item">
                      <a class="nav-link" href="{{route('group_insert_user')}}" class="card-category">
                        <i class="material-icons">groups</i>New user to group
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                       
                        <th> ID</th>
                        <th>User</th>
                        <th>Group Name</th>
                        <th>Crated date</th>
                        <th>Updated date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                          @if(count($group_users) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($group_users as $group_u)
                                <tr>
                                <td>{{$group_u->g_id}}</td>
                                <td>{{$group_u->name}}</td>
                                <td>
                                    {{$group_u->group_name}}
                                </td>
        
                                <td>{{$group_u->created_at}}</td>
                                <td>{{$group_u->updated_at}}</td>
                                <td>
                                    <a href="{{route('group_user_edit', $group_u->g_id)}}">
                                    <i class="material-icons">edit</i>
                                    </a>
                                    <a href="{{route('group_user_delete', $group_u->g_id)}}">
                                    <i class="material-icons">auto_delete</i>
                                    </a>
                                </td>
                                </tr>
                                @endforeach
                            @endif
                      </tbody>
                    </table>
                    
                  </div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection