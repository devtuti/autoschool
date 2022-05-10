@extends('layouts.back')
@section('title')
    Groups
@endsection
@section('css')
@endsection

@section('page_name')
    Group list
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
                      <a class="nav-link" href="{{route('new_group')}}" class="card-category">
                        <i class="material-icons">add</i>New group
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" href="{{route('group_users')}}" class="card-category">
                        <i class="material-icons">groups</i>Group user list
                      </a>
                    </li>

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
                        <th>Teacher</th>
                        <th>Group Name</th>
                        <th>Status</th>
                        <th>Crated date</th>
                        <th>Updated date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                          @if(count($groups) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($groups as $group)
                                <tr>
                                <td>{{$group->g_id}}</td>
                                <td>{{$group->name_familya}}</td>
                                <td>
                                    {{$group->group_name}}
                                </td>
                                <td>
                                    @if($group->status==0)
                                    Passive
                                    @else
                                    Active
                                    @endif
                                </td>
                                <td>{{$group->created_at}}</td>
                                <td>{{$group->updated_at}}</td>
                                <td>
                                    <a href="{{route('group_edit', $group->g_id)}}">
                                    <i class="material-icons">edit</i>
                                    </a>
                                    <a href="{{route('group_delete', $group->g_id)}}">
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