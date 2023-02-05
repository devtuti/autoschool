@extends('layouts.front')
<meta name="csrf-token" content="{{ csrf_token() }}">
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

      <div class="shadow p-3 mb-5 bg-body-tertiary rounded">{{$k->kurs_name}}</div>

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
                        {{$k->kurs_content}}
                        <h4>Kursdaki movzular:</h4>
                        <ul class="list-group">
                        @foreach($k->kurscategory as $kcat)
                                <li class="list-group-item"><a href="{{route('course.lessons')}}/{{$kcat->id}}">{{$kcat->kcat_name}}</a></li>
                        @endforeach
                            
                            </ul>
                        <h4>Qiymeti: {{$k->price}} azn</h4>
                        <h5>Endirimi: {{$k->discount}} %</h5>
                        <h5>Yekun qiymet: {{$kurs_price}} azn</h5>
                        <p class="text-start">Teacher: {{$k->admin->name_familya}}</p>
                        <div id="like_count">
                          <a href="javascript:void(0);" class="link-black text-sm" onclick="kurs_like('{{$k->id}}')"><i class="far fa-thumbs-up mr-1"></i>{{count($course_like)}} Like</a>
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
                        xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                            booth letterpress, commodo enim craft beer mlkshk 
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
            data = data + "<div class='post' id='sid"+value.id+"'>"
            data = data +   '<div class="user-block">'
            data = data +     '<img class="img-circle img-bordered-sm" src="'+user_url+'/'+value.user.photo+'" alt="user image">'
            data = data +         '<span class="username">'
            data = data +           '<a href="{{route('profile')}}">'+value.user.name+'</a>'
            data = data +           '<a href="javascript:void(0);" class="float-right btn-tool" onclick="course_c_delete('+value.id+')"><i class="fas fa-times"></i></a>'
            data = data +         '</span>'
            data = data +         '<span class="description">'+value.created_at+'</span>'
            data = data +    '</div>'

                data = data + '<p>'+value.comments+'</p>'
                //data = data + '<p>'
               
                data = data +    '<a href="javascript:void(0);" class="link-black text-sm" onclick="course_c_like('+value.id+')"><i class="far fa-thumbs-up mr-1"></i>5 Like /</a>'
                 
                data = data +    '<a href="javascript:void(0);" class="link-black text-sm share_edit" id="'+value.id+'" onclick="com_edit('+value.id+')"> Edit</a>'
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
</script>
@endsection