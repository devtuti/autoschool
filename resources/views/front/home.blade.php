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
    

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">User test correct count</h5>
                @foreach($user_correct_count as $u_c_c)
                  <p class="card-text">{{$u_c_c->user_correct_count}} </p>               
                  <p class="card-text">{{$faiz}}%</p>
                 
                @endforeach
              </div>
            </div>

            <div class="card card-primary card-outline">
              @foreach($hit as $h)
              <div class="card-body">
                <h5 class="card-title">{{$h->name}}</h5>

                <p class="card-text">
                  {{$h->user_date}}
                </p>
                <a href="#" class="card-link">{{$h->quest_count}}</a><br>


                
              </div>
              @endforeach
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
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
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Special title treatment</h6>

                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
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
            alert(data.msg);
          }
        }
      });

       //reset input file
    $('input[type="file"][name="share_photo"]').val('');
    //image preview
    $('input[type="file"][name="share_photo"]').on('change',function(){
      var image_path = $(this)[0].value;
      var image_holder = $('.img-holder');
      var extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();
      //alert(extension);
    })

    });

    
  })
</script>
@endsection

 

 
