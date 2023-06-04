@extends('layouts.front')
<meta name="csrf-token" content="{{ csrf_token() }}">
<?php
 //echo $current_month = date('M Y', strtotime('-2 month'));
 $months = array();
 $count = 0;
 while($count <= 11){
  $months[] = date('M Y', strtotime('-'.$count.'month'));
  $count++;
 }
 //echo '<pre>'; print_r($months); die;
 $dataPoints = array(
  /*array("y" => $courseCounts[11], "label" => $months[11]),
  array("y" => $courseCounts[10], "label" => $months[10]),
  array("y" => $courseCounts[9], "label" => $months[9]),
  array("y" => $courseCounts[8], "label" => $months[8]),
  array("y" => $courseCounts[7], "label" => $months[7]),
  array("y" => $courseCounts[6], "label" => $months[6]),
  array("y" => $courseCounts[5], "label" => $months[5]),
  array("y" => $courseCounts[4], "label" => $months[4]),
  array("y" => $courseCounts[3], "label" => $months[3]),*/
   array("y" => $courseCounts[2], "label" => $months[2]),
   array("y" => $courseCounts[1], "label" => $months[1]),
   array("y" => $courseCounts[0], "label" => $months[0]),
   
 );
  
 ?>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Course Report"
	},
	axisY: {
		title: "Number of Course"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

@section('title')
    Course page
@endsection
@section('css')

@endsection

@section('content')
 <!-- Main Sidebar Container -->
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

      <!-- Main content -->
      <div class="content"><br>
      <div class="card card-solid">

      <div class="shadow p-3 mb-5 bg-body-tertiary rounded"></div>

            <div class="card-body">
                  
                  <div class="x_content">

                  <ul class="nav nav-tabs justify-content-end bar_tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home1" role="tab" aria-controls="home" aria-selected="true">Course about</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile1" role="tab" aria-controls="profile" aria-selected="false">Course comments</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact1" role="tab" aria-controls="contact" aria-selected="false">Ne qeder satilib</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="home1" role="tabpanel" aria-labelledby="home-tab">
                      

                      <br>
                      <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">{{$k->kurs_name}}</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
              {{$k->kurs_content}}
              </div>
              <div class="card-body" style="display: block;">
                <h4>Kursdaki movzular:</h4>
                        <ul class="list-group">
                        @foreach($k->kurscategory as $kcat)
                                <li class="list-group-item"><a href="{{route('course.lessons')}}/{{$kcat->id}}">{{$kcat->kcat_name}}</a></li>
                        @endforeach
                            
                        </ul>
              </div>

              <div class="card-body" style="display: block;">
                <ul>
                  <li>Qiymeti: {{$k->price}} azn</li>
                  <li>Endirimi: {{$k->discount}} %</li>
                  <li>Yekun qiymet: {{$kurs_price}} azn</li>
                  
                </ul>

              </div>
            
              <div class="card-body" style="display: block;">
                <p class="text-start">Teacher: {{$k->admin->name_familya}}</p>
              </div>
              <div class="card-body" style="display: block;">
                <div id="like_count">
                    <a href="javascript:void(0);" class="link-black text-sm" onclick="kurs_like('{{$k->id}}')"><i class="far fa-thumbs-up mr-1"></i>{{count($course_like)}} Like</a>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
                          
                        
          </div>
                      
                      <div class="tab-pane fade" id="profile1" role="tabpanel" aria-labelledby="profile-tab">
                      <br/><div id="activity"></div><br/>
                        <div class="form-group" >
                          <div class="col-md-9 col-sm-9 ">
                            <textarea class="resizable_textarea form-control" id="course_comment" placeholder="Kurs haqqda fikrinizi bildirin.."></textarea><br>
                            <button type="button" class="btn btn-primary">Cancel</button>
                            <button type="reset" class="btn btn-primary">Reset</button>
                            <button type="submit" class="btn btn-success" onclick="comments_insert('{{$k->id}}')">Submit</button>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="contact1" role="tabpanel" aria-labelledby="contact-tab">
                                        
                        <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                     
                      </div>
                    </div><!-- tab-content -->

                  </div> <!-- x_content -->
                </div> <!-- card-body -->
              </div> <!-- card -->
              <div class="clearfix"></div>

                  
      </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('js')
<!-- ChartJS -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
  let user_url =  "{{asset('users/')}}";
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function kurs_like(id){
    //alert(id);
    $.ajax({
        type: "POST",
        dataType:'json', 
        data:{id:id},
        url: "{{route('course.like.post')}}",
        success:function(response){
          fetchcourselike();
        }
      });
  }

  function fetchcourselike(){
    $.ajax({
        type:'GET',
        dataType: 'json',
        url: '{{route("course.like_count")}}',
        success:function(res){
          //console.log(res); 
          
         var data = '<a href="javascript:void(0);" class="link-black text-sm" onclick=""><i class="far fa-thumbs-up mr-1"></i>'+res+' Like</a>'
          $('#like_count').html(data);
        }
      })
  }
 

  function fetchAllcomments(){
      
      $.ajax({
        type:'GET',
        dataType: 'json',
        url: '{{route("course.comments")}}',
        success:function(response){
          console.log(response);
          var data = ""
          $.each(response.comments, function(key, value){
            data = data + "<div class='post' id='cid"+value.id+"'>"
            data = data +   '<div class="user-block">'
            data = data +     '<img class="img-circle img-bordered-sm" src="'+user_url+'/'+value.user.photo+'" alt="user image">'
            data = data +         '<span class="username">'
            data = data +           '<a href="{{route('profile')}}">'+value.user.name+'</a>'
            data = data +           '<a href="javascript:void(0);" class="float-right btn-tool" onclick="course_c_delete('+value.id+')"><i class="fas fa-times"></i></a>'
            data = data +         '</span>'
            data = data +         '<span class="description">'+value.created_at+'</span>'
            data = data +    '</div>'
            
            // COMMENT EDIT
            
                data = data +    '<div class="input-group input-group-sm mb-2" style="display:none;" id="com_edit'+value.id+'">'
                data = data +      '<input type="text" class="form-control form-control-sm" id="com'+value.id+'" placeholder="Reyi yenile">'
                data = data +      '<div class="input-group-append">'
                data = data +         '<button type="submit" class="btn btn-danger" onclick="com_updated('+value.id+')">Edit comment</button>'
                data = data +      '</div>'
                data = data +     '</div>'

                data = data + '<p>'+value.comments+'</p>'
                //data = data + '<p>'
               
                data = data +    '<a href="javascript:void(0);" class="link-black text-sm" onclick="course_c_like('+value.id+')"><i class="far fa-thumbs-up mr-1"></i>'+value.course_comment_like.length+' Like /</a>'
                 
                data = data +    '<a href="javascript:void(0);" class="link-black text-sm" id="'+value.id+'" onclick="comment_edit('+value.id+')"> Edit</a>'
          })
          $('#activity').html(data);
        }
      })
    }

    fetchAllcomments();

    function comments_insert(id){
      var com = $('#course_comment').val();
     
      $.ajax({
        type: "POST",
        dataType:'json', 
        data:{id:id, com:com},
        url: "{{route('course.comment.insert')}}/"+id,
        success:function(response){
          //console.log(response);
          fetchAllcomments();
    
        }
      });
    }

    function comment_edit(id){
      $.ajax({
           url: "{{route('course.comment.edit')}}/"+id,
           method:"GET",
           data:{id:id},
           cache:false,
            success: function(response){ 
            
                document.querySelector('#com_edit'+id).removeAttribute("style");
                document.getElementById("com"+id).value = response;
              
             }
          });
     }

     function com_updated(id){
      var com_edit = $('#com'+id).val();
        $.ajax({
          type: "PUT",
          dataType:'json', 
          data:{com_edit:com_edit},
          url: "{{route('course.com.edit.post')}}/"+id,
          success:function(response){
            fetchAllcomments();
      
          }
        });
     }

     function course_c_delete(id){
      if(confirm("Silmeye eminsiniz??")){
      $.ajax({
           url: "{{route('course.com.delete')}}/"+id,
           type:"GET",
           data:{
             id:id
           },
           dataType:'json',
           cache:false,
            success: function(response){ 
              $("#cid"+id).remove();
              fetchAllcomments();
           }
       });
    }
     }

     function course_c_like(id){
      $.ajax({
        type: "POST",
        dataType:'json', 
        data:{id:id},
        url: "{{route('course.comment.like.post')}}",
        success:function(response){
          fetchAllcomments();
        }
      });
     }
</script>
@endsection