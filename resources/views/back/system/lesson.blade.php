@extends('layouts.back')
@section('title')
    Lessons
@endsection
@section('css')
@endsection

@section('page_name')
    Lesson list
@endsection

@section('content')
<div class="row">
             
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> </h4>
                  <!--<p class="card-category"> </p>-->
                  <form action="{{route('lesson_all_delete')}}" method="post">
                      @csrf
                      @method('DELETE')
                  <ul class="nav">
                    
                    <li class="nav-item">
                      <button type="submit" class="btn btn-primary pull-right">Delete all</button>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" href="{{route('new_lesson')}}" class="card-category">
                        <i class="material-icons">add</i>New lesson
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('lesson_trashed')}}" class="card-category">
                        <i class="material-icons">delete</i>Deleted lessons
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
                        <th>Category</th>
                        <th>Lesson Name</th>
                        <th>Status</th>
                        <th>Crated date</th>
                        <th>Updated date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                          @if(count($lessons) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($lessons as $lesson)
                                <tr>
                                <td><input type="checkbox" name="lesson_id[]" value="{{$lesson->id}}"></td>
                                <td>{{$lesson->id}}</td>
                                <td>
                                    {{$lesson->cat_name}}
                                </td>
                                <td>{{$lesson->lesson_name}}</td>
                                <td>
                                    @if($lesson->status==0)
                                    Passive
                                    @else
                                    Active
                                    @endif
                                </td>
                                <td>{{$lesson->created_at}}</td>
                                <td>{{$lesson->updated_at}}</td>
                                <td>
                                    <a href="{{route('lesson_edit', $lesson->id)}}">
                                    <i class="material-icons">edit</i>
                                    </a>
                                    <a href="{{route('lesson_delete', $lesson->id)}}">
                                    <i class="material-icons">auto_delete</i>
                                    </a>
                                </td>
                                </tr>
                                @endforeach
                            @endif
                      </tbody>
                    </table>
                    {{$lessons->links()}}
                  </div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection