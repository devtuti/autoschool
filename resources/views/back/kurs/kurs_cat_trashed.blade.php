@extends('layouts.back')
@section('title')
   Trashed Kurs Categories
@endsection
@section('css')
@endsection

@section('page_name')
    Trashed Kurs Category list
@endsection

@section('content')
<div class="row">
             
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> </h4>
                  <!--<p class="card-category"> </p>-->
                  <form action="{{route('kurs.cat_trashed_delete')}}" method="post">
                      @csrf
                      @method('DELETE')
                  <ul class="nav">
                    
                    <li class="nav-item">
                      <button type="submit" class="btn btn-primary pull-right">Delete all</button>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" href="{{route('kurs.new_cat')}}" class="card-category">
                        <i class="material-icons">add</i>New category
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('kurs_cat')}}" class="card-category">
                        All categories
                      </a>
                    </li>
                    
                  </ul>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                        <th></th>
                        <th> ID</th>
                        <th> Kurs Name</th>
                        <th>Parent category</th>
                        <th> Name</th>
                        <th>Status</th>
                        <th>Crated date</th>
                        <th>Updated date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                      @if(count($categories) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                        @else
                        @foreach($categories as $cat)
                        <tr>
                          <td><input type="checkbox" name="cat_id[]" value="{{$cat->id}}"></td>
                          <td>{{$cat->id}}</td>
                          <td>{{$cat->kurs_name}}</td>
                          <td>
                            @if($cat->sub_id==0)
                              Parent category
                            @else
                              {{\App\Http\Controllers\back\KursCategoryController::getParentsTree($cat)}}
                            @endif
                          </td>
                          <td>{{$cat->kcat_name}}</td>
                          <td>
                            @if($cat->kstatus==0)
                              Passive
                            @else
                              Active
                            @endif
                          </td>
                          <td>{{$cat->k_date}}</td>
                          <td>{{$cat->k_u_date}}</td>
                          <td>
                            <a href="{{route('kurs.cat_restore', $cat->k_id)}}">
                            <i class="material-icons">settings_backup_restore</i>
                            </a>
                            <a href="{{route('kurs.cat_destroy', $cat->k_id)}}">
                              <i class="material-icons">auto_delete</i>
                            </a>
                          </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>

                    {{$categories->links()}}
                  </div>
                </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection