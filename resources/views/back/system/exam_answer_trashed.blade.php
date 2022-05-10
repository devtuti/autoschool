@extends('layouts.back')
@section('title')
    Trashed Exam Answers
@endsection
@section('css')
@endsection

@section('page_name')
Trashed exam answer list
@endsection

@section('content')
<div class="row">
             
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> </h4>
                  <!--<p class="card-category"> </p>-->
                  <form action="{{route('exam_answer_trashed_delete')}}" method="post">
                      @csrf
                      @method('DELETE')
                  <ul class="nav">
                    
                    <li class="nav-item">
                      <button type="submit" class="btn btn-primary pull-right">Delete all</button>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" href="{{route('new_exam_answer')}}" class="card-category">
                        <i class="material-icons">add</i>New answer
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{route('exam_answers')}}" class="card-category">
                        All answers
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
                        <th>Question Name</th>
                        <th>Answer</th>
                        <th>Correct answer</th>
                        <th>Crated date</th>
                        <th>Updated date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                          @if(count($answers) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($answers as $answer)
                                <tr>
                                <td><input type="checkbox" name="answer_id[]" value="{{$answer->e_id}}"></td>
                                <td>{{$answer->id}}</td>
                                <td>
                                    {{$answer->question_name}}
                                </td>
                                <td>{{$answer->answer}}</td>
                                <td>
                                    @if($answer->correct_answer==0)
                                    Yanliw
                                    @else
                                    Dogru
                                    @endif
                                </td>
                                <td>{{$answer->created_at}}</td>
                                <td>{{$answer->updated_at}}</td>
                                <td>
                                    <a href="{{route('exam_answer_restore', $answer->e_id)}}">
                                    <i class="material-icons">settings_backup_restore</i>
                                    </a>
                                    <a href="{{route('exam_answer_destroy', $answer->e_id)}}">
                                    <i class="material-icons">auto_delete</i>
                                    </a>
                                </td>
                                </tr>
                                @endforeach
                            @endif
                      </tbody>
                    </table>
                    {{$answers->links()}}
                  </div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection