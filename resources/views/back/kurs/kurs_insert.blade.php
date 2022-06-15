@extends('layouts.back')
@section('title')
     New kurs
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Kurs add</h4>
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
                  <form action="{{route('post_kurs')}}" method="post">
                    @csrf
                  <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Kurs name</label>
                          <input type="text" class="form-control" name="kurs_name">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Price</label>
                          <input type="number" class="form-control" name="price">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Discount</label>
                          <input type="number" class="form-control" name="discount">
                        </div>
                    </div>

                      <div class="col-md-3">
                        <div class="form-group">
                        <label class="bmd-label-floating">Status</label>
                        <select id="inputState" class="form-control" name="status">
                          <option selected value="0">Passiv</option>
                          <option value="1">Active</option>
                        </select>
                        </div>
                      </div>
                      
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Content Text</label>
                          <div class="form-group">
                            <label class="bmd-label-floating"> Kurs haqqda melumat.</label>
                            <textarea class="form-control" rows="5" name="kurs_content"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
  
                    <button type="submit" class="btn btn-primary pull-right">İnsert kurs</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')

@endsection