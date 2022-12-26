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
  }*/
 
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
          console.log(response);
          var data = ""
          $.each(response.share, function(key, value){
            
            data = data + "<div class='post' id='sid"+value.id+"'>"
            data = data +   '<div class="user-block">'
            data = data +     '<img class="img-circle img-bordered-sm" src="'+user_url+'/'+value.user.photo+'" alt="user image">'
            data = data +         '<span class="username">'
            data = data +           '<a href="{{route('profile')}}">'+value.user.name+'</a>'
            data = data +           '<a href="javascript:void(0);" class="float-right btn-tool" onclick="share_delete('+value.id+')"><i class="fas fa-times"></i></a>'
            data = data +         '</span>'
            data = data +         '<span class="description">'+value.created_at+'</span>'
            data = data +    '</div>'

            if(value.photo !=''){
              var share_file = "shares/"+value.photo
              if(share_file){
              //if(File::exists("shares/"+value.photo)){
                data = data + '<div class="row mb-3">'
                data = data +   '<div class="col-sm-6">'
                data = data +      '<img class="img-fluid" src="'+user_url+'/'+value.user.photo+'" alt="Photo">'
                data = data +    '</div>'
                data = data +    '<div class="col-sm-1">'
                data = data +       '<a href="javascript:void(0);" onclick="share_photo_delete('+value.id+')" class="float-right btn-tool"><i class="fas fa-times"></i></a>'
                data = data +     '</div>'
                data = data +  '</div>'
              }
            }
                data = data + '<p>'+value.content_text+'</p>'
                //data = data + '<p>'
               
                data = data +    '<a href="javascript:void(0);" class="link-black text-sm" onclick="share_like('+value.id+')"><i class="far fa-thumbs-up mr-1"></i>'+value.like_share.length+' Like /</a>'
                 
                data = data +    '<a href="javascript:void(0);" class="link-black text-sm share_edit" id="'+value.id+'" onclick="share_edit('+value.id+')"> Edit</a>'
                 /* COMMENT COUNT   */
                data = data +    '<span class="float-right">'
                data = data +       '<a href="#" class="link-black text-sm">'
                data = data +          '<i class="far fa-comments mr-1"></i> Comments ('+value.comment.length+')'
                data = data +       '</a>'
                data = data +    '</span>'
          
            $.each(response.comment, function(keys, values){
                  if(value.id==values.share_id){
                /* COMMENTS */
                    data = data +   '<div class="user-block ml-3">'
                    data = data +     '<img class="img-circle img-bordered-sm" src="'+user_url+'/'+value.user.photo+'" alt="user image">'
                    data = data +         '<span class="username">'
                    data = data +           '<a href="{{route('profile')}}">'+value.user.name+'</a>'
                    data = data +           '<a href="javascript:void(0);" onclick="com_delete('+values.id+')" class="float-right btn-tool mr-2"><i class="fas fa-times"></i></a>'
                    data = data +         '</span>'
                    data = data +         '<span class="description">'+values.created_at+'</span>'
                    data = data +    '</div>'
                    data = data + '<p class="ml-3" id="cid'+values.id+'">'+values.share_comment+'</p>'
                
                    data = data +    '<a href="javascript:void(0);" class="link-black text-sm" onclick="com_like('+values.id+')"><i class="far fa-thumbs-up mr-2 ml-3 mb-2"></i>'+values.like_comment.length+' Like </a>'
                    data = data +    '<a href="javascript:void(0);" class="link-black text-sm mr-2" id="'+values.id+'" onclick="com_edit('+values.id+')">/ Edit</a>'
                    data = data +    '<a href="javascript:void(0);" class="link-black text-sm mr-2" id="'+values.id+'" onclick="com_new('+values.id+')">/ Cavabla</a>'
                   // data = data +    '<a href="javascript:void(0);" class="link-black text-sm mr-2" onclick="">Reply</a>'

                    /* FOR COMMENT COUNT   */
                        data = data +    '<span class="float-right">'
                        data = data +       '<a href="#" class="link-black text-sm">'
                        data = data +          '<i class="far fa-comments mr-1"></i> Comments ('+values.children.length+')'
                        data = data +       '</a>'
                        data = data +    '</span>'

                       // COMMENT EDIT      
                data = data +    '<div class="input-group input-group-sm mb-2" style="display:none" id="com_edit'+values.id+'">'
                data = data +      '<input type="text" class="form-control form-control-sm" id="com'+values.id+'" placeholder="Response">'
                data = data +      '<div class="input-group-append">'
                data = data +         '<button type="submit" class="btn btn-danger" onclick="com_updated('+values.id+')">Edit comment</button>'
                data = data +      '</div>'
                data = data +        '<span class="text-danger error-text" id ="share_post_error"></span>'
                data = data +     '</div>'

                // COMMENT FOR COMMENT INSERT      
                data = data +    '<div class="input-group input-group-sm mb-2" style="display:none" id="com_insert'+values.id+'">'
                data = data +      '<input type="text" class="form-control form-control-sm" id="comnew'+values.id+'" placeholder="New comment">'
                data = data +       '<input type="hidden" id="share_id'+values.id+'" value="'+value.id+'">'
                data = data +      '<div class="input-group-append">'
                data = data +         '<button type="submit" class="btn btn-danger" onclick="com_insert('+values.id+')">New comment</button>'
                data = data +      '</div>'
                data = data +        '<span class="text-danger error-text" id ="share_post_error"></span>'
                data = data +     '</div>'


                        $.each(values.children, function(key_f_c, value_for_comment){
                         
                          /* COMMENTS FOR COMMENT */
                          data = data +   '<div class="user-block ml-5">'
                          data = data +     '<img class="img-circle img-bordered-sm" src="'+user_url+'/'+value.user.photo+'" alt="user image">'
                          data = data +         '<span class="username">'
                          data = data +           '<a href="{{route('profile')}}">'+value.user.name+'</a>'
                          data = data +           '<a href="javascript:void(0);" onclick="comchild_delete('+values.id+')" class="float-right btn-tool mr-3"><i class="fas fa-times"></i></a>'
                          data = data +         '</span>'
                          data = data +         '<span class="description">'+value_for_comment.created_at+'</span>'
                          data = data +    '</div>'
                          data = data + '<p class="ml-5" id="cid'+value_for_comment.id+'">'+value_for_comment.share_comment+'</p>'
                      
                          data = data +    '<a href="javascript:void(0);" class="link-black text-sm" onclick="comchild_like('+value_for_comment.id+')"><i class="far fa-thumbs-up mr-2 ml-5 mb-2"></i> Like </a>'
                          data = data +    '<a href="javascript:void(0);" class="link-black text-sm" id="'+value_for_comment.id+'" onclick="comchild_edit('+value_for_comment.id+')">/ Edit</a>'
                          data = data +    '<a href="javascript:void(0);" class="link-black text-sm mr-2" id="'+value_for_comment.id+'" onclick="comchild_new('+values.id+')">/ Reply</a>'
                          
                          
                    // COMMENT CHILD EDIT      
                data = data +    '<div class="input-group input-group-sm mb-2" style="display:none;" id="comchild_edit'+value_for_comment.id+'">'
                data = data +      '<input type="text" class="form-control form-control-sm" id="comchild'+value_for_comment.id+'" placeholder="Response">'
                data = data +      '<div class="input-group-append">'
                data = data +         '<button type="submit" class="btn btn-danger" onclick="comchild_updated('+value_for_comment.id+')">Edit comment</button>'
                data = data +      '</div>'
                data = data +        '<span class="text-danger error-text" id ="share_post_error"></span>'
                data = data +     '</div>'

                // COMMENT FOR COMMENT CHILD INSERT      
                data = data +    '<div class="input-group input-group-sm mb-2" style="display:none;" id="comchild_insert'+value_for_comment.id+'">'
                data = data +     '<p id="childcom'+value_for_comment.id+'"></p>'
                data = data +      '<input type="text" class="form-control form-control-sm" id="comchildnew'+value_for_comment.id+'" placeholder="New comment">'
                data = data +       '<input type="hidden" id="childshare_id'+value_for_comment.id+'" value="'+value.id+'">'
                data = data +      '<div class="input-group-append">'
                data = data +         '<button type="submit" class="btn btn-danger" onclick="comchild_insert('+value_for_comment.id+')">New comment</button>'
                data = data +      '</div>'
                data = data +        '<span class="text-danger error-text" id ="share_post_error"></span>'
                data = data +     '</div>'

                        })
           
                  }
            
            })
              // SHARE EDIT

                data = data +    '<div class="input-group input-group-sm mb-2" style="display:none;" id="sh_edit'+value.id+'">'
                data = data +      '<input type="text" class="form-control form-control-sm" id="sh'+value.id+'" placeholder="Response">'
                data = data +      '<div class="input-group-append">'
                data = data +         '<button type="submit" class="btn btn-danger" onclick="share_updated('+value.id+')">Edit share</button>'
                data = data +      '</div>'
                data = data +        '<span class="text-danger error-text" id ="share_post_error"></span>'
                data = data +     '</div>'

             // COMMENT INSERT
                //data = data +    '<input type="hidden" id="sh_id" name="sh_id" value="'+value.sh_id+'">'
                data = data +    '<div class="input-group input-group-sm mb-0 share_com" id="sh_com'+value.id+'">'
                data = data +      '<input type="text" class="form-control form-control-sm" id="sh_for_comment'+value.id+'" placeholder="Response" name="">'
                data = data +      '<div class="input-group-append">'
                data = data +         '<button type="submit" class="btn btn-danger" onclick="share_for_comment('+value.id+')">Send</button>'
                data = data +      '</div>'
                data = data +      '<span class="text-danger error-text" id ="share_post_error"></span>'
                data = data +    '</div>'
              
                data = data + '</div>'

          })
        
          $('#activity').html(data);
        }

      })/*.done(function() {
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
      });*/
    }
     fetchAllShares();

// Share edit view
     function share_edit(id){
      $.ajax({
           url: "{{route('share')}}/"+id,
           method:"GET",
           data:{id:id},
           cache:false,
            success: function(response){ 
            
                document.querySelector('#sh_edit'+id).removeAttribute("style");
                document.getElementById("sh"+id).value = response;
              
             }
          });
     }

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
            //console.log(response);
            fetchAllShares();
      
          },
          error:function(error){
            $('#share_post_error').text(error.responseJSON.errors.sh_edit);
          }
        });

      
    }

    // SHARE LIKE

    function share_like(id){
      $.ajax({
        type: "POST",
        dataType:'json', 
        data:{id:id},
        url: "{{route('share.like.post')}}",
        success:function(response){
          //console.log(response);
          fetchAllShares();
    
        },
        error:function(error){
          //console.log(error);
          $('#share_post_error').text(error.responseJSON.errors.id);
        }
      });
    }

    // share for comment insert

    function share_for_comment(id){
      
      var sh_for_comment = $('#sh_for_comment'+id).val();

      $.ajax({
        type: "POST",
        dataType:'json', 
        data:{id:id, sh_for_comment:sh_for_comment},
        url: "{{route('share.comment.post')}}",
        success:function(response){
          //console.log(response);
          fetchAllShares();
    
        },
        error:function(error){
          //console.log(error);
          $('#share_post_error').text(error.responseJSON.errors.sh_for_comment);
        }
      });
    }

    // Comment edit view
    function com_edit(id){
      $.ajax({
           url: "{{route('comment')}}/"+id,
           method:"GET",
           data:{id:id},
           cache:false,
            success: function(resp){ 
            
                document.querySelector('#com_edit'+id).removeAttribute("style");
                document.getElementById("com"+id).value = resp;
              //console.log(response);
             }
          });
     }

      // comment edit

    function com_updated(id){
      var com_edit = $('#com'+id).val();
      //var sh_for_comment = $('input[name=content_text]').val();
        $.ajax({
          type: "PUT",
          dataType:'json', 
          data:{com_edit:com_edit},
          url: "{{route('com.edit.post')}}/"+id,
          success:function(response){
            //console.log(response);
            fetchAllShares();
      
          },
          error:function(error){
            $('#share_post_error').text(error.responseJSON.errors.com_edit);
          }
        });

      
    }

    // Comment for comment
    function com_new(id){
      document.querySelector('#com_insert'+id).removeAttribute("style");
       
     }

     // Comment for comment insert

     function com_insert(id){
      
      var com_new = $('#comnew'+id).val();
      var share_id = $('#share_id'+id).val();

      $.ajax({
        type: "POST",
        dataType:'json', 
        data:{id:id, com_new:com_new, share_id:share_id},
        url: "{{route('comforcom')}}/"+id,
        success:function(response){
          //console.log(response);
          fetchAllShares();
    
        },
        error:function(error){
          //console.log(error);
          $('#share_post_error').text(error.responseJSON.errors.com_new);
        }
      });
    }

     // Comment for comment child
     function comchild_new(id){
      
      $.ajax({
           url: "{{route('commentchild')}}/"+id,
           method:"GET",
           data:{id:id},
           cache:false,
            success: function(r){ 
              
              document.querySelector('#comchild_insert'+id).removeAttribute('style');
              document.querySelector('#childcom'+id).text(r);
             
             
              //console.log(r);
             }
          });
       
     }

     // COMMENT CHILD INSERT
     function comchild_insert(id){
      
      var com_new = $('#comchildnew'+id).val();
      var share_id = $('#childshare_id'+id).val();

      $.ajax({
        type: "POST",
        dataType:'json', 
        data:{id:id, com_new:com_new, share_id:share_id},
        url: "{{route('comforcomchild')}}/"+id,
        success:function(response){
          //console.log(response);
          fetchAllShares();
    
        },
        error:function(error){
          //console.log(error);
          $('#share_post_error').text(error.responseJSON.errors.com_new);
        }
      });
    }


     // Comment child edit view
    function comchild_edit(id){
      $.ajax({
           url: "{{route('comment')}}/"+id,
           method:"GET",
           data:{id:id},
           cache:false,
            success: function(res){ 
            
                document.querySelector('#comchild_edit'+id).removeAttribute("style");
                document.getElementById("comchild"+id).value = res;
              //console.log(response);
             }
          });
     }

      // comment child edit

    function comchild_updated(id){
      var comchild_edit = $('#comchild'+id).val();
      //var sh_for_comment = $('input[name=content_text]').val();
        $.ajax({
          type: "PUT",
          dataType:'json', 
          data:{comchild_edit:comchild_edit},
          url: "{{route('comchild.edit.post')}}/"+id,
          success:function(response){
            //console.log(response);
            fetchAllShares();
      
          },
          error:function(error){
            $('#share_post_error').text(error.responseJSON.errors.comchild_edit);
          }
        });

      
    }

    // COMMENT LIKE

    function com_like(id){
      $.ajax({
        type: "POST",
        dataType:'json', 
        data:{id:id},
        url: "{{route('comment.like.post')}}",
        success:function(response){
          fetchAllShares();
    
        },
        error:function(error){
          $('#share_post_error').text(error.responseJSON.errors.id);
        }
      });
    }

    // COMMENT CHILD LIKE

    function comchild_like(id){
      $.ajax({
        type: "POST",
        dataType:'json', 
        data:{id:id},
        url: "{{route('comment.like.post')}}",
        success:function(response){
          fetchAllShares();
    
        },
        error:function(error){
          $('#share_post_error').text(error.responseJSON.errors.id);
        }
      });
    }

    // Comment delete
  function com_delete(id){
    if(confirm("Silmeye eminsiniz??")){
      $.ajax({
           url: "{{route('com.delete')}}/"+id,
           type:"GET",
           data:{
             id:id
           },
           dataType:'json',
           cache:false,
            success: function(response){ 
              $("#cid"+id).remove();
              fetchAllShares();
           }
       });
    }
        
    }

    // Comment delete
  function comchild_delete(id){
    if(confirm("Silmeye eminsiniz??")){
      $.ajax({
           url: "{{route('comchild.delete')}}/"+id,
           type:"GET",
           data:{
             id:id
           },
           dataType:'json',
           cache:false,
            success: function(response){ 
              $("#cid"+id).remove();
              fetchAllShares();
           }
       });
    }
        
    }
   
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

 

 
