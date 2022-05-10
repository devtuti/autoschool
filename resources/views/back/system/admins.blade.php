@extends('layouts.back')
@section('title')
    Admin users
@endsection
@section('css')
@endsection

@section('page_name')
    Admin users
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
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Grade</th>
                        <th>Crated date</th>
                        <th>Updated date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                          @if(count($admins) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($admins as $admin)
                                @if(Auth::guard('admin')->user()->id!=$admin->id)
                                <tr>
                                <td>{{$admin->id}}</td>
                                <td>{{$admin->name_familya}}</td>
                                <td>
                                    {{$admin->email}}
                                </td>
                                <td>
                                    {{$admin->phone}}
                                </td>
                                <td>
                                    @if($admin->status==0)
                                    Deaktiv
                                    @else
                                    Aktiv
                                    @endif
                                </td>
                                <td>
                                    @if($admin->grade==0)
                                    Gozleme
                                    @elseif($admin->grade==2)
                                    Muellim
                                    @else
                                    @endif
                                </td>
                                <td>{{$admin->created_at}}</td>
                                <td>{{$admin->updated_at}}</td>
                                <td>
                                    <a href="{{route('admins_edit', $admin->id)}}">
                                    <i class="material-icons">edit</i>
                                    </a>
                                    
                                </td>
                                </tr>
                                @else
                                @endif
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