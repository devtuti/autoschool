
@extends('layouts.front')
@section('title')
     New amount
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
            <h1>Payment</h1>
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
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Amount add</h4>
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
                  
                      <form action="{{route('post_amount')}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Amount</label>
                            <input type="text" class="form-control" name="amount">
                          </div>
                      </div>
                      <button type="submit" class="btn btn-primary pull-right">İnsert amount</button>
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

@endsection