@extends('layouts.back')
@section('title')
     New exam answer
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Exam answer add</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">
                @if($errors->any())
                  @foreach($errors->all() as $error)
                  <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b> Owibka - </b> {{$error}}</span>
                  </div>
                  @endforeach
                @endif
                  <form action="{{route('post_exam_answer')}}" method="post" enctype="multipart/form-data">
                    @csrf
                  <div class="row">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Question Name</th>
                                    <th>Answer</th>
                                    <th>Correct answer</th>
                                    <th>
                                        <a href="javascript:void(0)" class="addRow"><i class="material-icons">add</i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    
                                    <td>
                                    <select name="question" class="form-control">
                                        
                                        @foreach($questions as $question)
                                        <option value="{{$question->id}}">{{$question->question_name}}</option>
                                        @endforeach
                                    </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="answer[]">
                                    </td>

                                    <td>
                                    <select id="inputState" class="form-control" name="correct[]">
                                        <option selected value="0">Yanliw</option>
                                        <option value="1">Dogru</option>
                                    </select>
                                    </td>

                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-danger remove"><i class="material-icons">remove</i>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td><input type="submit" name="" value="Insert answer" class="btn btn-primary pull-right"></td>
                                </tr>
                            </tfoot>
                        </table>

                    
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('.addRow').on('click', function(){
            addRow();
        });

        function addRow(){
            var tr = '<tr>'+
            '<td><input type="text" name="answer[]" class="form-control"></td>'+
            '<td><select id="inputState" class="form-control" name="correct[]">'+
                '<option selected value="0">Yanliw</option>'+
                '<option value="1">Dogru</option>'+
                '</select> </td>'+
            '<td><a href="javascript:void(0)" class="btn btn-danger remove"><i class="material-icons">remove</i></a></td>'+
            '</tr>';
            $('tbody').append(tr);
        };


        $(document).on('click', '.remove', function(){
            var last = $('tbody tr').length;
            if(last==1){
                alert("no deleted one row");
            }else{
                $(this).parent().parent().remove();
            }
            
        });
    });
</script>  
@endsection