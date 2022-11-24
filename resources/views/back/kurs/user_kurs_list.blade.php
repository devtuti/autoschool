@extends('layouts.back')
@section('title')
    Users in the course
@endsection
@section('css')
@endsection

@section('page_name')
    Users in the course
@endsection

@section('content')
<div class="row">
             
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> </h4>
              
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                        <th>Id</th>
                        <th>Kurs Name</th>
                        <th>Users</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Payment</th>
                        <th>Created date</th>
                       
                      </thead>
                      <tbody>
                          @if(count($users) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($users as $u)
                               
                                <tr>
                                <td>{{$u->kurs_u_id}}</td>
                                <td>{{$u->kurs_name}}</td>
                                <td> {{$u->name}} </td>
                                <td> {{$u->price}} </td>
                                <td> {{$u->discount}} % </td>
                                <td>
                                    <?php echo ($u->price*$u->discount)/100; ?> azn     
                                </td>
                             

                                <td>{{$u->created_at}}</td>

                                </tr>
                                
                                @endforeach
                            @endif
                      </tbody>
                    </table>
                   
                  </div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection