
@extends('layouts.front')
@section('title')
     Mesaj
@endsection
@section('css')
@endsection

@section('content')
<!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
          
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">
                    @isset($teachername->name_familya)
                      {{$teachername->name_familya}} 
                    @endisset
                    @isset($username->name)
                      {{$username->name}} 
                    @endisset
                  </h4>
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
                  
                    </div> 
                    <div class="card-body">
                        @foreach($mesajs as $mesaj)

                        <div class="col-md-12">
                            
                            <div class="row"><h5 class="card-title">{{Auth::user()->name}}</h5></div>
                            <div class="row"><p class="card-text"> {{$mesaj->sms}} </p></div>
                              @if(!empty($mesaj->photo))
                              <div class="row"><img src="{{asset('mesaj/'.$mesaj->photo)}}" width="150px" height="150px"></div>
                              @endif
                              <div class="row"><p class="card-text"> 
                                <i>
                                  @if(empty($mesaj->updated_at))
                                    {{$mesaj->created_at}}
                                  @else
                                    {{$mesaj->updated_at}}
                                  @endif
                                </i>
                              </p></div>
                              
                              
                              <div class="row"><a href="" class="card-link" data-toggle="modal" data-target="#modalContactForm" onclick='return mesaj("{{$mesaj->id}}");'>Edit</a>
                              <a href="{{route('sms.delete')}}/{{$mesaj->id}}" class="card-link">Delete</a></div>


                              <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                
                              </div>

                        </div>
                        @endforeach
                    
                        <form action="{{route('post.mesaj')}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="col-md-12">
                        <input type="hidden" name="touser" value="{{$id}}">                             
                      
                        <label for="exampleFormControlTextarea1" class="form-label">Mesajiniz</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="sms"></textarea><br>

                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="sms_photo">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                     </div>
                      <br><button type="submit" class="btn btn-primary pull-right">New mesaj</button>
                      <div class="clearfix"></div>
                      </form>
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
<script>
  
    function mesaj(id){
        //alert(id);
        //return true;
        $.ajax({
           url: "{{route('sms.edit')}}",
           method:"GET",
           data:{id:id},
           cache:false,
            success: function(data){ 
                $(".modal").html(data);
                
           }
       });
    }

</script>
@endsection