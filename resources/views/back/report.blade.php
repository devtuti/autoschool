@extends('layouts.back')
@section('title')
    Report
@endsection
@section('css')
@endsection

@section('page_name')
    Report list
@endsection

@section('content')
<div class="row">
             
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> </h4>
                  <!--<p class="card-category"> </p>-->
              
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
                
              
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
      
                        <th>User</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Crated date</th>
                        <th>Updated date</th>
                        
                      </thead>
                      <tbody>
                        <form action="{{route('reports')}}" method="get">
                        
                          <input type="date" name="from" max="<?php date("Y:m:d") ?>">
                          <input type="date" name="to">
                          <input type="submit" value="Filtr" name="filtr">
                        </form>


                          @if(count($payment) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($payment as $p)
                                <tr>
                               
                                <td>{{$p->name}}</td>
                                <td>
                                    {{$p->amount}} azn
                                </td>
                                <td>
                                    @if($p->status==0)
                                    Passive
                                    @else
                                    Active
                                    @endif
                                </td>
                                <td>{{$p->created_at}}</td>
                                <td>{{$p->updated_at}}</td>
                          
                                </tr>
                                @endforeach
                                <tr>
                                    <td><h3>Total:</h3></td>
                                    <td></td>
                                    <td><h3>{{$sum}} azn</h3></td>
                                </tr>
                            @endif
                      </tbody>
                    </table>
                    
                  </div>
                  
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection