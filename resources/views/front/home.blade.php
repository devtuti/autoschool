@extends('layouts.front')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title')
    Home page
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('front/plugins/summernote/summernote-bs4.min.css')}}">
<style>
  /* .edit_share{
    display:none;
  } */
 
</style>
@endsection

@section('content')

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Home</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="col-md-12">
        @if($last_test)
          <div class="col-lg-12">

            <div class="card">
              <div class="card-body">

                    <p class="text-center">
                      <strong>User test correct count</strong>
                    </p>

                    <div class="progress-group">
                      
                      {{$last_test->cat_name}}
                      <span class="float-right"><b>{{$last_test->correct_percent}}%</b>/{{$last_test->correct_count}}</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar <?php if($last_test->correct_percent<31) echo 'bg-warning'; elseif($last_test->correct_percent<51) echo 'bg-danger'; elseif($last_test->correct_percent<71) echo 'bg-primary'; elseif($last_test->correct_percent>80) echo 'bg-success'; else{}?>" style="width: {{$last_test->correct_percent}}%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->
           
                  <p class="card-text"><i>{{$last_test->created_at}}</i></p>
                    
              </div>
            </div>
            


            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Top 10</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">User Name</th>
                      <th>Category</th>
                      <th>Date</th>
                      <th>Progress</th>
                      <th style="width: 40px">Label</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($hit as $h)
                    <tr>
                      <td>{{$h->name}}</td>
                      <td>{{$h->cat_name}}</td>
                      <td>{{$h->test_date}}</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar <?php if($h->correct_percent<51) echo 'progress-bar-danger'; elseif($h->correct_percent<81) echo 'bg-warning'; elseif($h->correct_percent>80) echo 'bg-success'; else {}?>" style="width: {{$h->correct_percent}}%"></div>
                        </div>
                      </td>
                      <td><span class="badge  <?php if($h->correct_percent<51) echo 'bg-danger'; elseif($h->correct_percent<81) echo 'bg-warning'; elseif($h->correct_percent>80) echo 'bg-success'; else{} ?>">{{$h->correct_percent}}%</span></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            

            <div class="card card-primary card-outline">
             
              <div class="card-body">
                <h5 class="card-title">
                  <a href="" class="card-link"></a> 
                </h5>
                <p class="card-text"></p>
              </div>
            </div><!-- /.card -->

          </div>
          @endif
          <!-- /.col-md-6 -->
          @if($last_test)
          <div class="col-lg-12">
          @else
          <div class="col-lg-12">
          @endif
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Paylasin</h5>
              </div>
              <form method="POST" enctype="multipart/form-data" id="form" action="{{route('post_share')}}" >
                @csrf
              <div class="card-body">
                <div class="form-group">
                  <label>Post</label>
                  <textarea id="summernote" name="share_post">
                      
                  </textarea>
                  <span class="text-danger error-text share_post_error"></span>
                </div>

                <div class="form-group">
                    <div class="form-check">
                      @foreach($teachers as $teacher)
                        <input class="form-check-input"name="teacher" type="checkbox" value="{{$teacher->id}}">
                        <label class="form-check-label">{{$teacher->name_familya}}</label>
                      @endforeach
                    </div>

                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="customFile" name="share_photo">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                      <span class="text-danger error-text share_image_error"></span>
                    </div>
                    <div class="img-holder"></div>
                    <button type="submit" class="btn btn-primary">Paylas</button>
                </div>
              </form>
           
              <div class="card-body">
                <ul id="updateform_errorlist"></ul>
                <div id="success_message"></div>
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                  
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <!-- /.col-md-6 -->
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection


 

@section('js')
<script src="{{asset('front/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script>
  let user_url =  "{{asset('users/')}}";
  let share_url =  "{{asset('shares/')}}";

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(function () {
        // Summernote
        $('#summernote').summernote();
  });

   function fetchAllShares(){
      
      $.ajax({
        type:'GET',
        dataType: 'json',
        url: '{{route("home.share")}}',
        success:function(response){
          //console.log(value.content_text);
          var data = ""
          $.each(response['posts'], function(key, value){
            data = data + "<div class='post' id='sid"+value.sh_id+"'>"
            data = data +   '<div class="user-block">'
            data = data +     '<img class="img-circle img-bordered-sm" src="'+user_url+'/'+value.u_photo+'" alt="user image">'
            data = data +         '<span class="username">'
            data = data +           '<a href="{{route('profile')}}">'+value.name+'</a>'
            data = data +           '<a href="javascript:void(0);" class="float-right btn-tool" onclick="share_delete('+value.sh_id+')"><i class="fas fa-times"></i></a>'
            data = data +         '</span>'
            data = data +         '<span class="description">'+value.sh_date+'</span>'
            data = data +    '</div>'
            if(value.photo !=''){
              var share_file = "shares/"+value.photo
              if(share_file){
              //if(File::exists("shares/"+value.photo)){
                data = data + '<div class="row mb-3">'
                data = data +   '<div class="col-sm-6">'
                data = data +      '<img class="img-fluid" src="'+user_url+'/'+value.u_photo+'" alt="Photo">'
                data = data +    '</div>'
                data = data +    '<div class="col-sm-1">'
                data = data +       '<a href="javascript:void(0);" onclick="share_photo_delete('+value.sh_id+')" class="float-right btn-tool"><i class="fas fa-times"></i></a>'
                data = data +     '</div>'
                data = data +  '</div>'
              }
            }

                data = data + '<p>'+value.content_text+'</p>'
                //data = data + '<p>'
                data = data +    '<a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i>4 Like </a>'
                data = data +    '<a href="javascript:void(0);" class="link-black text-sm share_edit" id="'+value.sh_id+'"> Edit</a>'
            $.each(response['count_comment'], function(keyc, valuec){
              if(value.sh_id==valuec.share_id){
               
                /* COMMENT COUNT   */
                data = data +    '<span class="float-right">'
                data = data +       '<a href="#" class="link-black text-sm">'
                data = data +          '<i class="far fa-comments mr-1"></i> Comments ('+valuec.count_com+')'
                data = data +       '</a>'
                data = data +    '</span>'
                //console.log(valuec.count_com);
                $.each(response['comments'], function(keys, values){
                  if(value.sh_id==values.share_id){
                /* COMMENTS */
                    data = data +   '<div class="user-block ml-3">'
                    data = data +     '<img class="img-circle img-bordered-sm" src="'+user_url+'/'+value.u_photo+'" alt="user image">'
                    data = data +         '<span class="username">'
                    data = data +           '<a href="{{route('profile')}}">'+value.name+'</a>'
                    data = data +           '<a href="javascript:void(0);" onclick="" class="float-right btn-tool mr-2"><i class="fas fa-times"></i></a>'
                    data = data +         '</span>'
                    data = data +         '<span class="description">'+values.created_at+'</span>'
                    data = data +    '</div>'
                    data = data + '<p class="ml-3">'+values.share_comment+'</p>'
                
                    data = data +    '<a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-2 ml-3 mb-2"></i>74 Like </a>'
                    data = data +    '<a href="javascript:void(0);" class="link-black text-sm mr-2" onclick=""> Edit</a>'
                    data = data +    '<a href="javascript:void(0);" class="link-black text-sm mr-2" onclick="">Reply</a>'

                    $.each(response['count_comment_subcomment'], function(keycsub, valuecsub){
                      if(values.id==valuecsub.sub_comment_id){
                
                        /* FOR COMMENT COUNT   */
                        data = data +    '<span class="float-right">'
                        data = data +       '<a href="#" class="link-black text-sm">'
                        data = data +          '<i class="far fa-comments mr-1"></i> Comments ('+valuecsub.count_subcom+')'
                        data = data +       '</a>'
                        data = data +    '</span>'

                        $.each(response['comments_for_comment'], function(key_f_c, value_for_comment){
                          if(values.id==value_for_comment.sub_comment_id){
                        /* COMMENTS FOR COMMENT */
                        data = data +   '<div class="user-block ml-5">'
                        data = data +     '<img class="img-circle img-bordered-sm" src="'+user_url+'/'+value.u_photo+'" alt="user image">'
                        data = data +         '<span class="username">'
                        data = data +           '<a href="{{route('profile')}}">'+value.name+'</a>'
                        data = data +           '<a href="javascript:void(0);" onclick="" class="float-right btn-tool mr-3"><i class="fas fa-times"></i></a>'
                        data = data +         '</span>'
                        data = data +         '<span class="description">'+value_for_comment.created_at+'</span>'
                        data = data +    '</div>'
                        data = data + '<p class="ml-5">'+value_for_comment.share_comment+'</p>'
                    
                        data = data +    '<a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-2 ml-5 mb-2"></i>28 Like </a>'
                        data = data +    '<a href="javascript:void(0);" class="link-black text-sm mr-2" onclick=""> More</a>'

                        
                       
                      }
                    });
                  }
                });
                  }
                });
              }
            });
                
                //data = data +  '</p>'
                data = data +    '<div class="input-group input-group-sm mb-2" style="display:none;" id="sh_edit'+value.sh_id+'">'
                data = data +      '<input type="text" class="form-control form-control-sm" id="sh'+value.sh_id+'" placeholder="Response">'
                data = data +      '<div class="input-group-append">'
                data = data +         '<button type="submit" class="btn btn-danger" onclick="share_updated('+value.sh_id+')">Send</button>'
                data = data +      '</div>'
                data = data +        '<span class="text-danger error-text" id ="share_post_error"></span>'
                data = data +     '</div>'
             
                //data = data +    '<input type="hidden" id="sh_id" name="sh_id" value="'+value.sh_id+'">'
                data = data +    '<div class="input-group input-group-sm mb-0 share_com" id="sh_com'+value.sh_id+'">'
                data = data +      '<input type="text" class="form-control form-control-sm" id="sh_for_comment'+value.sh_id+'" placeholder="Response" name="content_text[]">'
                data = data +      '<div class="input-group-append">'
                data = data +         '<button type="submit" class="btn btn-danger" onclick="share_for_comment()">Send</button>'
                data = data +      '</div>'
                data = data +      '<span class="text-danger error-text" id ="share_post_error"></span>'
                data = data +    '</div>'
              
                data = data + '</div>'
            
            
            
            /*$.each(response['comments'], function(keys, values){
              if(value.sh_id==values.share_id){
                console.log(value.name);
                console.log(values.share_comment);
                
              }
           
            });*/
          });
          $('#activity').html(data);
        }

      }).done(function() {
  // Share edit view
          document.querySelector('.share_edit').addEventListener("click", function(event){
          let sh_id = event.target.id
          $.ajax({
           url: "{{route('share')}}/"+sh_id,
           method:"GET",
           data:{id:sh_id},
           cache:false,
            success: function(response){ 
            
                //$('#sh_edit'+sh_id).css("display","inline");
                document.querySelector('#sh_edit'+sh_id).removeAttribute("style");
                document.getElementById("sh"+sh_id).value = response;
              
           }
       });
     })
      });
    }
     fetchAllShares();
   
    // Share delete
  function share_delete(id){
    if(confirm("Silmeye eminsiniz??")){
      $.ajax({
           url: "{{route('share.delete')}}/"+id,
           type:"GET",
           data:{
             id:id
           },
           dataType:'json',
           cache:false,
            success: function(response){ 
              $("#sid"+id).remove();
              fetchAllShares();
           }
       });
    }
        
    }



    // share photo delete 

  function share_photo_delete(id){
    if(confirm("Silmeye eminsiniz??")){
      $.ajax({
           url: "{{route('share.photo.delete')}}/"+id,
           type:"GET",
           data:{
             id:id
           },
           dataType:'json',
           cache:false,
            success: function(response){ 
              
                $("#sid"+id).remove();
                fetchAllShares();
             
           }
       });
    }
        
    }

    


        // ajax insert share
  $(document).ready(function(){

    $('#form').on('submit', function(e){
      e.preventDefault();
      var form = this; 
      
      $.ajax({
        url:$(form).attr('action'),
        type:$(form).attr('method'),
        data:new FormData(form),
        dataType:'json',
        contentType:false,
        cache:false,
        processData:false,
                  /*beforeSend:function(){
                    $(form).find('span.error-text').text('');
                  },*/
        success:function(data){
                if(data.code==0){
                    /*$.each(data.error, function(prefix,val){
                      $(form).find('span.'+prefix+'_error').text(val[0]);
                    });*/
                  }else{
                    $(form)[0].reset();
                    $(".tab-pane").html(data.msg);
                    fetchAllShares();
            //console.log('successfuly added');
          }
        }
      });
    });
  });

      // share edit

    function share_updated(id){
      var sh_edit = $('#sh'+id).val();
      //var sh_for_comment = $('input[name=content_text]').val();
        $.ajax({
          type: "PUT",
          dataType:'json', 
          data:{sh_edit:sh_edit},
          url: "{{route('share.edit.post')}}/"+id,
          success:function(response){
            fetchAllShares();
      
          },
          error:function(error){
            $('#share_post_error').text(error.responseJSON.errors.sh_edit);
          }
        });

      
    }

    function share_for_comment(){
      var sh_id = $('input[name=sh_id]').val();
      var sh_for_comment = $('input[name=content_text]').val();

      $.ajax({
        type: "POST",
        dataType:'json', 
        data:{sh_id:sh_id, sh_for_comment:sh_for_comment},
        url: "{{route('share.comment.post')}}",
        success:function(response){
          fetchAllShares();
    
        },
        error:function(error){
          console.log(error);
          $('#share_post_error').text(error.responseJSON.errors.sh_for_comment);
        }
      });
    }

    /*$('#formshare').on('submit', function(e){
      e.preventDefault(); 
      var sh_edit = $('input[name=share_edit]').val();
      var formshare = this; 
      alert(sh_edit);
      $.ajax({
        url: "{{route('share.edit.post')}}"+sh_edit,
        type: "PUT",
        data:new FormData(formshare),
        dataType:'json', 
        success:function(response){
          if(response.status==400){
            $('#updateform_errorlist').html("");
            $('#updateform_errorlist').addClass('alert alert-danger');
            $.each(response.errors, function(key,err_values){
              $('#updateform_errorlist').append('<li>'+err_values+'</li>');
            });
          }else{
            $('#updateform_errorlist').html("");
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success');
            $('#success_message').text(response.message);
            fetchAllShares();

          }
        }
      });


    });*/


    
  
  
</script>
@endsection

 

 
