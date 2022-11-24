@extends('layouts.back')
@section('title')
    User the course question answers
@endsection
@section('css')
@endsection

@section('page_name')
    User the course question answers
@endsection

@section('content')
<div class="row">
             
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> </h4>
                  
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                        <th>Id</th>
                        <th>User Name</th>
                        <th>Question name</th>
                        <th>Answer</th>
                        <th>Created date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                          @if(count($user_answers) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($user_answers as $u_a)
                               
                                <tr>
                                <td>{{$u_a->u_k_a_id}}</td>
                                <td>{{$u_a->name}}</td>
                                <td> {{$u_a->question_name}}</td>
                                
                                <td>
                                    @if($u_a->answer==$u_a->correct_answer)
                                        <p style="color:green;">{{$u_a->answer}}</p>
                                    @else
                                        <p style="color:red;">{{$u_a->answer}}</p>
                                    @endif
                                </td>

                                <td>{{$u_a->created_at}}</td>

                                <td>
                                    <a href="{{route('kurs.question.look', $u_a->u_k_a_id)}}">
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