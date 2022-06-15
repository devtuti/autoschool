@extends('layouts.back')
@section('title')
    Test Report
@endsection
@section('css')
@endsection

@section('page_name')
    Test Report list
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
                  
                      <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                        <select class="form-select" id="inputGroupSelect01" name="groups" onchange="formg()">
                          <option selected>Choose...</option>
                          @foreach($groups as $g)
                            <option value="{{$g->id}}">{{$g->group_name}}</option>
                          @endforeach
                          
                        </select>
                        
                      </div>
              
                  </div>

                  <table class="table table-hover">
                      <thead class="">
      
                        <th>User</th>
                        <th>Categoriya</th>
                        <th>Faiz</th>
                        <th>Crated date</th>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  
                </div>
              </div>
            </div>
@endsection

@section('js')
<script>
  function formg(){
    var groups = document.getElementById("inputGroupSelect01").value; 
  //alert(groups);
  fetchusers();
    function fetchusers(){
      $.ajax({
           url: "{{route('test.report.users')}}",
           method:"GET",
           dataTpe:"json",
           data:{groups:groups},
            success: function(response){ 
              //alert(response.group);
               $.each(response.user_resultats, function(key, item){
                $('tbody').append('<tr>\
                <td>'+item.name+'</td>\
                <td>'+item.cat_name+'</td>\
                <td>'+item.correct_percent+'</td>\
                <td>'+item.user_r_date+'</td>\
                </tr>');
               });
           }
       });
    }
      
  }
    

</script>
@endsection