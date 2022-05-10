@extends('layouts.back')
@section('title')
    Exam Questions
@endsection
@section('css')
@endsection

@section('page_name')
    Exam Questions list
@endsection

@section('content')
<div class="row">
             
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> </h4>
                  <!--<p class="card-category"> </p>-->
                  <form action="{{route('exam_question_all_delete')}}" method="post">
                      @csrf
                      @method('DELETE')
                  <ul class="nav">
                    
                    <li class="nav-item">
                      <button type="submit" class="btn btn-primary pull-right">Delete all</button>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" href="{{route('new_exam_question')}}" class="card-category">
                        <i class="material-icons">add</i>New exam question
                      </a>
                    </li>
                    @if(count($questions) > 0 )
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('exam_answers')}}" class="card-category">
                        <i class="material-icons">view_agenda</i>Exam answers
                      </a>
                    </li>
                    @endif
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('exam_question_trashed')}}" class="card-category">
                        <i class="material-icons">delete</i>Deleted questions
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
                        <th>Exam Name</th>
                        <th>Status</th>
                        <th>Crated date</th>
                        <th>Updated date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                          @if(count($questions) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($questions as $question)
                                <tr>
                                <td><input type="checkbox" name="question_id[]" value="{{$question->id}}"></td>
                                <td>{{$question->t_q_id}}</td>
                                <td>
                                    {{$question->cat_name}}
                                </td>
                                <td>{{$question->question_name}}</td>
                                <td>
                                    @if($question->status==0)
                                    Passive
                                    @else
                                    Active
                                    @endif
                                </td>
                                <td>{{$question->created_at}}</td>
                                <td>{{$question->updated_at}}</td>
                                <td>
                                    <a href="{{route('exam_question_edit', $question->t_q_id)}}">
                                    <i class="material-icons">edit</i>
                                    </a>
                                    <a href="{{route('exam_question_delete', $question->t_q_id)}}">
                                    <i class="material-icons">auto_delete</i>
                                    </a>
                                </td>
                                </tr>
                                @endforeach
                            @endif
                      </tbody>
                    </table>
                    {{$questions->links()}}
                  </div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection