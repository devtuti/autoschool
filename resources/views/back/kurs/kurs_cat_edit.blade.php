@extends('layouts.back')
@section('title')
     Update kurs category
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Category edit</h4>
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
                  <form action="{{route('kurs.cat_edit_post', $cats->id)}}" method="post">
                    @csrf
                  <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Kurs</label>
                          <select name="kurs" class="form-control">
                              
                              @foreach($kurs as $k)
                                @if($cats->kurs_id==$k->id)
                                    <option value="{{$k->id}}" selected>{{$k->kurs_name}}</option>
                                @else
                                    <option value="{{$k->id}}">{{$k->kurs_name}}</option>
                                @endif
                              @endforeach
                          </select>
                        </div>
                      </div>
                      
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Category name</label>
                          <input type="text" class="form-control" name="cat_name" value="{{$cats->kcat_name}}">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Categories</label>
                          <select name="category" class="form-control">
                              
                              @foreach($parent as $p)
                                @if($cats->sub_id==$p->id)
                                    <option value="0">Ana kategori</option>
                                    <option value="{{$p->id}}" selected>{{$p->kcat_name}}</option>
                                @else
                                    <option value="{{$p->id}}">{{$p->kcat_name}}</option>
                                    <option value="0" selected>Ana kategori</option>
                                @endif
                              @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                        <label class="bmd-label-floating">Status</label>
                        <select id="inputState" class="form-control" name="status">
                            @if($cats->status==0)
                                <option selected value="0">Passiv</option>
                                <option value="1">Active</option>
                            @else
                                <option value="0">Passiv</option>
                                <option selected value="1">Active</option>
                            @endif
                        </select>
                        </div>
                      </div>
                      
                    </div>
                   
                    <button type="submit" class="btn btn-primary pull-right">Update category</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
@endsection