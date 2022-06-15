@extends('layouts.front')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title')
    Home page
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('front/plugins/summernote/summernote-bs4.min.css')}}">
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
        <div class="row">
        @if($last_test)
          <div class="col-lg-6">

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
          <div class="col-lg-6">
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
                  @foreach($shares as $share)
                    <!-- Post -->
                    <div class="post" id="sid{{$share->sh_id}}">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="{{asset('users/'.$share->u_photo)}}" alt="user image">
                        <span class="username">
                          <a href="#">{{$share->name}}.</a>
                          <a href="javascript:void(0);" class="float-right btn-tool" onclick='return share_delete("{{$share->sh_id}}");'><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">{{$share->sh_date}}</span>
                      </div>
                      <!-- /.user-block -->
                      @if(!empty($share->photo))
                        @if(File::exists("shares/".$share->photo))
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="{{asset('shares/'.$share->photo)}}" alt="Photo">
                        </div>
                        <div class="col-sm-1">
                          <a href="javascript:void(0);" onclick='return share_photo_delete("{{$share->sh_id}}");' class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </div>
                      </div>
                      @endif
                      @endif
                      <p>
                        {!! $share->content_text !!}
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <a href="javascript:void(0);" class="link-black text-sm" onclick='return shares("{{$share->sh_id}}");'> Edit</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <form class="form-horizontal" id="formshare" action="" method="">
                        @csrf
                        <input type="hidden" id="share_edit{{$share->sh_id}}">
                        <div class="input-group input-group-sm mb-0">
                          <input type="text" class="form-control form-control-sm" id="sh{{$share->sh_id}}" placeholder="Response">
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-danger">Send</button>
                          </div>
                          <span class="text-danger error-text share_post_error"></span>
                        </div>
                      </form>
                    </div>
                    <!-- /.post -->
                  @endforeach
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
  $(function () {
        // Summernote
        $('#summernote').summernote();
  });
  
  // Share edit view
  function shares(id){
        $.ajax({
           url: "{{route('share')}}",
           method:"GET",
           data:{id:id},
           cache:false,
            success: function(data){ 
            document.getElementById("sh"+id).name = 'content_text';
            document.getElementById("sh"+id).value = data;
            document.getElementById("share_edit"+id).name = 'share_edit';
            document.getElementById("share_edit"+id).value = id;
           }
       });
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
             
           }
       });
    }
        
    }
    $(document).ready(function(){
    // ajax insert share

    $('#form').on('submit', function(e){
      e.preventDefault();
      var form = this; 
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url:$(form).attr('action'),
        type:$(form).attr('method'),
        data:new FormData(form),
        dataType:'json',
        contentType:false,
        cache:false,
        processData:false,
        beforeSend:function(){
          $(form).find('span.error-text').text('');
        },
        success:function(data){
         if(data.code==0){
            $.each(data.error, function(prefix,val){
              $(form).find('span.'+prefix+'_error').text(val[0]);
            });
          }else{
            $(form)[0].reset();
            $(".tab-pane").html(data.msg);
            //fetchAllShares();
        
          }
        }
      });
    });

      // share edit
      
      $('#formshare').on('submit', function(e){
      e.preventDefault(); 
      var sh_edit = $('input[name=share_edit]').val();
      //alert(sh_edit);
      var formshare = this; 
      
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

          }
        }
      });
    });

        //reset input file
      $('input[type="file"][name="share_photo"]').val('');
      //image preview
      $('input[type="file"][name="share_photo"]').on('change',function(){
        var image_path = $(this)[0].value;
        var image_holder = $('.img-holder');
        var extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();
        //alert(extension);
      });

    /*fetchAllShares();
    function fetchAllShares(){
      $.get('{{route("shares")}}',{},function(data){
        $('#activity').html(data.result);
      },'json');
    }*/
  });
  
</script>
@endsection

 

 
