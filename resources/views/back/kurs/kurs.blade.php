@extends('layouts.back')
@section('title')
    Kurs
@endsection
@section('css')
@endsection

@section('page_name')
    Kurs
@endsection

@section('content')
<div class="row">
             
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> </h4>
                  <!--<p class="card-category"> </p>-->
                  <ul class="nav">
                    
                     <li class="nav-item">
                      <a class="nav-link" href="{{route('new.kurs')}}" class="card-category">
                        <i class="material-icons">add</i>New kurs
                      </a>
                    </li>
                    
                  </ul>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                        <th>Id</th>
                        <th>Kurs Name</th>
                        <th>Teacher</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Created date</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                          @if(count($kurs) ==0 )
                          <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                                </button>
                                <span>
                                <b> Resultat - </b> Not data</span>
                            </div>
                            @else
                                @foreach($kurs as $k)
                               
                                <tr>
                                <td>{{$k->k_id}}</td>
                                <td>{{$k->kurs_name}}</td>
                                <td>
                                    {{$k->name_familya}}
                                </td>
                                <td>
                                  @if(empty($k->discount))
                                    {{$k->price}}azn
                                  @else
                                    <?php echo ($k->price*$k->discount)/100; ?> azn
                                  @endif
                                </td>
                                <td>
                                    {{$k->discount}}%
                                </td>
                                <td>
                                    @if($k->status==0)
                                    Deaktiv
                                    @else
                                    Aktiv
                                    @endif
                                </td>

                                <td>{{$k->k_date}}</td>

                                <td>
                                    <a href="{{route('kurs.edit', $k->k_id)}}">
                                    <i class="material-icons">edit</i>
                                    </a>
                                    
                                </td>
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