@extends('layouts.front')
@section('title')
    Kurs test page
@endsection
@section('css')
@endsection

@section('content')

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tests</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
          
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
              <h5 class="card-title">Test sayi: {{$count_test}}</h5>
                <form action="{{route('course.test_user')}}" method="post">
                    @csrf
                    <input type="hidden" name="cat" value="{{$id}}">
                    <input type="hidden" name="user" value="{{Auth::user()->id}}">
                    <div class="form-group">
                    @foreach($tests as $test)
                        <input type="hidden" name="question[]{{$test->q_id}}" value="{{$test->q_id}}">
                        <p class="card-text">{{$test->question}}</p>
                        
                          @for ($x = 1; $x <= 5; $x++) 
                         
                          <div class="form-check">
                            <input class="form-check-input" type="radio" id="radio{{$test->q_id}}{{$x}}" name="answer[]{{$test->q_id}}" value="{{$x}}">
                            <label class="form-check-label">{{$x}}</label>
                          </div>
                          @endfor
                        
                    @endforeach
                    
                    </div>
                    @if($count_test>0)
                    <br/><button type="submit" onclick='return deleted();' class="btn btn-info">Cavabla</button>
                    @endif
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

    const selectcourse_radio = localStorage.getItem('selectcourse_radio{{$id}}')
            
        if (selectcourse_radio){
                const get_array = JSON.parse(selectcourse_radio)
                for (let radioId of get_array) {
                document.getElementById(radioId).checked = true;
            }
        }

    const radioBtn = document.querySelectorAll('input[type=radio]')
    radioBtn.forEach(btn => {
        btn.addEventListener('click', function(){
            const current_data =JSON.parse( localStorage.getItem('selectcourse_radio{{$id}}'))

            if (current_data){
                    current_data.push(btn.id)
                localStorage.setItem("selectcourse_radio{{$id}}", JSON.stringify(current_data) )
            }else{
                fist_data = []
                fist_data.push(btn.id)
                localStorage.setItem("selectcourse_radio{{$id}}", JSON.stringify(fist_data) )
            }       
        })
    })

    function deleted(){
      localStorage.removeItem("selectcourse_radio{{$id}}");
    }

</script>
@endsection

 

 
