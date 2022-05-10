@extends('layouts.back')
@section('title')
    Users
@endsection
@section('css')
@endsection

@section('page_name')
     Users
@endsection

@section('content')
<div class="row">
             
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> </h4>
                  <!--<p class="card-category"> </p>-->
                  
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Teacher</th>
                        <th>Status</th>
                        <th>Crated date</th>
                        <th>Updated date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                          @if(count($users) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($users as $user)
                                
                                <tr>
                                <td>{{$user->u_id}}</td>
                                <td>{{$user->name}}</td>
                                <td>
                                    {{$user->u_email}}
                                </td>
                                <td>
                                    {{$user->name_familya}}
                                </td>
                                <td>
                                    @if($user->u_status==0)
                                    Deaktiv
                                    @else
                                    Aktiv
                                    @endif
                                </td>
                                
                                <td>{{$user->u_created_at}}</td>
                                <td>{{$user->u_updated_at}}</td>
                                <td>
                                    <a href="{{route('users_edit', $user->u_id)}}">
                                    <i class="material-icons">edit</i>
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