@extends('layouts.back')
@section('title')
    Categories
@endsection
@section('css')
@endsection

@section('page_name')
    Category list
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
                      <button type="submit" class="btn btn-primary pull-right">Delete all</button>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" href="{{route('new_cat')}}" class="card-category">
                        <i class="material-icons">add</i>New category
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
                        <th>Parent category</th>
                        <th> Name</th>
                        <th>Status</th>
                        <th>Crated date</th>
                        <th>Updated date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                        @foreach($categories as $cat)
                        <tr>
                          <td><input type="checkbox" name="cat_id[]"></td>
                          <td>{{$cat->id}}</td>
                          <td>
                            @if($cat->sub_id==0)
                              Parent category
                            @else
                              {{\App\Http\Controllers\back\CategoryController::getParentsTree($cat)}}
                            @endif
                          </td>
                          <td>{{$cat->cat_name}}</td>
                          <td>
                            @if($cat->status==0)
                              Passive
                            @else
                              Active
                            @endif
                          </td>
                          <td>{{$cat->created_at}}</td>
                          <td>{{$cat->updated_at}}</td>
                          <td>
                            <a href="{{route('cat_edit', $cat->id)}}">
                            <i class="material-icons">edit</i>
                            </a>
                            <a href="{{route('cat_delete', $cat->id)}}">
                              <i class="material-icons">auto_delete</i>
                            </a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection