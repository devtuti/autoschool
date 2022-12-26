
@extends('layouts.front')
@section('title')
     New exam
@endsection
@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
          <br>
          
            <?php
            if($_POST){
            ?>
          <div class="card card-primary card-outline">
          @if($count_a>0) 
            @if($payment->amount>=5)
                <?php $i =1;?>     
                <div class="card-body">
                  <h5 class="card-title"></h5>
                  @foreach($questions as $question)
                      <input class="btn btn-primary pull-right" type="submit" onclick='return sual("{{$question->id}}");' value="{{$i}}" name="q_id">
                      
                  <?php $i++; ?>
                  @endforeach
                  <div class="card-body" id="card_body">
                    
                  </div>
                  
                   
                  
                </div>
                @else
                <div class="card-body">
                  <p class="card-text">
                      Balansiniz {{$payment->amount}} tewkil edir. Zehmet olmasa artirin..
                  </p>
              </div>
                @endif
              @else
              
                  <div class="card-body"><p class="card-text">Balansinizi artirin..</p></div>
              
              @endif
            </div><!-- /.card -->
            <?php }else{ ?>
                <div class="card card-primary card-outline">
                  <div class="card-body">
                    <form action="{{route('exam_post')}}" method="post">
                        @csrf
                      <button type="submit" name="submit" class="btn btn-primary pull-right">Start exam</button><br><br>
                    </form>
                  </div>
                </div>
          <?php } ?>
          </div>
          <!-- /.col-md-6 -->

                    
                    </div>  
                </div>
              </div>
            </div>
@endsection

@section('js')
<script>
  
    function sual(id){
        //alert(id);
        //return true;
        $.ajax({
           url: "{{route('question')}}",
           method:"GET",
           data:{id:id},
           cache:false,
            success: function(res){ 
              var data = ""
              $.each(res, function(key, value){
                data = data + '<p class="card-text">'+value.question+'</p>'
                data = data + '<br><div class="form-group"> <div class="custom-control custom-radio">'
                data = data + '<input class="custom-control-input" type="radio" id="customRadio1" name="answers[]" value="'+value.an_id+'">'
                data = data +'<label for="customRadio1" class="custom-control-label">'+value.answer+'</label>'
                data = data + '</div></div>'
                data = data + ' <br><input class="btn btn-primary pull-right" type="submit" value="Send Answer">'
                
              })
                $("#card_body").html(data);
                
           }
       });
    }

</script>
@endsection