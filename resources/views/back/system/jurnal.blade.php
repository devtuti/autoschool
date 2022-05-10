@extends('layouts.back')
@section('title')
    Jurnal
@endsection
@section('css')
@endsection

@section('page_name')
    Jurnal list
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
                      <a class="nav-link" href="{{route('jurnal_insert')}}" class="card-category">
                        <i class="material-icons">add</i>New jurnal
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                       
                        <th> ID</th>
                        <th>Category</th>
                        <th>Group Name</th>
                        <th>Status</th>
                        <th>Crated date</th>
                        <th>Updated date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                          @if(count($jurnals) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($jurnals as $jurnal)
                                <tr>
                                <td>{{$jurnal->j_id}}</td>
                                <td>{{$jurnal->cat_name}}</td>
                                <td>
                                    {{$jurnal->group_name}}
                                </td>
                                <td>
                                    @if($jurnal->status==0)
                                    Passive
                                    @else
                                    Active
                                    @endif
                                </td>
                                <td>{{$jurnal->created_at}}</td>
                                <td>{{$jurnal->updated_at}}</td>
                                <td>
                                    <a href="{{route('jurnal_edit', $jurnal->j_id)}}">
                                    <i class="material-icons">edit</i>
                                    </a>
                                    <a href="{{route('jurnal_delete', $jurnal->j_id)}}">
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