@extends('layouts.front')
@section('title')
    Lesson single page
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
              <div class="card-body">
              <h5 class="card-title">Test sayi: {{$count_test}}</h5>
                <form action="{{route('test_user')}}" method="post">
                    @csrf
                    <input type="hidden" name="user[]" value="{{Auth::user()->id}}">
                    <div class="form-group">
                    @foreach($tests as $test)
                        <input type="hidden" name="question{{$test->q_id}}" value="{{$test->q_id}}">
                        <p class="card-text">{{$test->question}}</p>
                        
                          @for ($x = 1; $x <= 5; $x++) 
                         
                          <div class="form-check">
                            <input class="form-check-input" type="radio" id="radio{{$test->q_id}}{{$x}}" name="answer{{$test->q_id}}" value="{{$x}}">
                            <label class="form-check-label">{{$x}}</label>
                          </div>
                          @endfor
                        
                    @endforeach
                    
                    </div>
                    <button type="submit" class="btn btn-info">Cavabla</button>
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

    const selected_radio = localStorage.getItem('selected_radio')
            
        if (selected_radio){
                const get_array = JSON.parse(selected_radio)
                for (let radioId of get_array) {
                document.getElementById(radioId).checked = true;
            }
        }

    const radioBtn = document.querySelectorAll('input[type=radio]')
    radioBtn.forEach(btn => {
        btn.addEventListener('click', function(){
            const current_data =JSON.parse( localStorage.getItem('selected_radio'))

            if (current_data){
                    current_data.push(btn.id)
                localStorage.setItem("selected_radio", JSON.stringify(current_data) )
            }else{
                fist_data = []
                fist_data.push(btn.id)
                localStorage.setItem("selected_radio", JSON.stringify(fist_data) )
            }       
        })
    })

</script>
@endsection

 

 
