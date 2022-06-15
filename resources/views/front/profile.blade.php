@extends('layouts.front')
@section('title')
    Profile page
@endsection
@section('css')
@endsection

@section('content')

  <!-- Main Sidebar Container -->
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
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
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{asset('users/'.$users->photo)}}"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{$users->name}}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>{{$last_test->cat_name}}</b> <a class="float-right">{{$last_test->correct_count}}</a>
                  </li>
                  
                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Resultats</a></li>
                  <li class="nav-item"><a class="nav-link" href="#test_resultat" data-toggle="tab">Tests</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    @foreach($shares as $share)
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="{{asset('users/'.$share->u_photo)}}" alt="user image">
                        <span class="username">
                          <a href="#">{{$share->name}}.</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">{{$share->sh_date}}</span>
                      </div>
                      <!-- /.user-block -->
                      @if(!empty($share->photo))
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="{{asset('shares/'.$share->photo)}}" alt="Photo">
                        </div>
                      </div>
                      @endif
                      <p>
                        {!! $share->content_text !!}
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <a href="#" class="link-black text-sm" onclick='return shares("{{$share->sh_id}}");'>/ Edit</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <form class="form-horizontal" enctype="multipart/form-data" method="post" action="" id="form">
                        @csrf
                        <input type="hidden" value="{{$share->sh_id}}" name="share_id">
                        <div class="input-group input-group-sm mb-0">
                          <input class="form-control form-control-sm" id="sh{{$share->sh_id}}" placeholder="Response" name="content_text">
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-danger">Send</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.post -->
                  @endforeach
                  </div>
                  <!-- /.tab-pane -->

                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                          <th style="width: 10px">#</th>
                            <th>Correct Count</th>
                            <th>Category</th>
                            <th>Progress</th>
                            <th style="width: 40px">Correct percent</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($user_resultats as $u_r)
                          <tr>
                          <td style="width: 10px">{{$u_r->u_r_id}}</td>
                            <td style="width: 10px">{{$u_r->correct_count}}</td>
                            <td>{{$u_r->cat_name}}</td>
                            <td>
                              <div class="progress progress-xs">
                                <div class="progress-bar <?php if($u_r->correct_percent<31) echo 'bg-warning'; elseif($u_r->correct_percent<51) echo 'bg-danger'; elseif($u_r->correct_percent<71) echo 'bg-primary'; elseif($u_r->correct_percent>80) echo 'bg-success'; else{}?>" style="width: {{$u_r->correct_percent}}%"></div>
                              </div>
                            </td>
                            <td><span class="badge <?php if($u_r->correct_percent<31) echo 'bg-warning'; elseif($u_r->correct_percent<51) echo 'bg-danger'; elseif($u_r->correct_percent<71) echo 'bg-primary'; elseif($u_r->correct_percent>80) echo 'bg-success'; else{}?>">{{$u_r->correct_percent}}%</span></td>
                            <td>{{$u_r->date}}</td>
                          </tr>
                          @endforeach

                        </tbody>
                      </table>

                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="test_resultat">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                    <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Question name</th>
                      <th>Date</th>
                      <th style="width: 40px">Answer</th>
                      <th>More</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($user_answers as $u_a)
                    <tr>
                      <td>{{$u_a->t_u_id}}</td>
                      <td>{{$u_a->question_name}}</td>
                      <td>
                      {{$u_a->u_date}}
                      </td>
                      <td><span class="badge <?php if($u_a->correct_answer==$u_a->answer) echo 'bg-success'; else echo 'bg-danger'; ?>">{{$u_a->answer}}</span></td>
                      <td>
                        <a href="#" data-toggle="modal" data-target="#modal-lg" onclick='return question("{{$u_a->question_id}}");'>Question</a>
                      </td>
                    </tr>
                    @endforeach
                      
                  </tbody>
                </table>
                    </div>
                  </div>
                <!-- /.tab-pane -->
                  <div class="modal fade" id="modal-lg">
                      
                    </div>
                    <!-- /.modal -->
                  

                  <div class="tab-pane" id="settings">
                    <form action="{{route('post.edit.profile', $users->id)}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" name="username" value="{{$users->name}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" name="email" value="{{$users->email}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="inputName2" name="pass" value="{{$users->password}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="Photo" class="col-sm-2 col-form-label">Photo</label>
                        <div class="col-sm-10">
                            <input type="file" id="Photo" class="form-control" name="photo" value="{{$users->photo}}">
                            <br><img src="{{asset('users/'.$users->photo)}}" width="100px" height="100px">
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Edit profile</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection

@section('js')
<script>
  
    function question(id){
        //alert(id);
        //return true;
        $.ajax({
           url: "{{route('profile.question')}}",
           method:"GET",
           data:{id:id},
           cache:false,
            success: function(data){ 
                $(".modal").html(data);
                
           }
       });
    }

    function shares(id){
        
        $.ajax({
           url: "{{route('share')}}",
           method:"GET",
           data:{id:id},
           cache:false,
            success: function(data){ 
              document.getElementById("sh"+id).value = data;
                
           }
       });
    }

   /* $(function () {
      $("#edit").click(function(){
        var form = '#form';
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            url: "{{ route('share.edit.post') }}",
            method: 'POST',
            data: new FormData(form),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(data){
              alert(data);
            }
        });
    });*/

</script>
@endsection

 

 
