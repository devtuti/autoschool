@extends('layouts.front')
@section('title')
    Balance page
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
            <h1>Balance</h1>
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
                <h5 class="card-title">Sizin Balansiniz: {{$balance}} rub</h5><br>
                @foreach($payments as $payment)
                <p class="card-text">
                  <!-- foreach ile exams parcalayib $balance - 0.5 cixacayiq. Imtahan verdiyi tarixide ekrana yazdiracayiq -->
                 {{$payment->amount}} rub - {{$payment->created_at}}
                </p>
                @endforeach
                
                <a href="{{route('payment')}}" class="card-link">Payment</a>
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
@endsection

 

 
