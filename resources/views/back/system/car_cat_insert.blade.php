@extends('layouts.back')
@section('title')
     New car category
@endsection
@section('css')
@endsection

@section('content')
<div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Car Category add</h4>
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
                  <form action="{{route('post_car_cat')}}" method="post">
                    @csrf
                  <div class="row">

                  <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Categories</th>
                            <th>Status</th>
                            <th>
                                <a href="javascript:void(0)" class="addRow"><i class="material-icons">add</i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" name="cat_name[]" class="form-control">
                            </td>

                            <td>
                              <select name="category[]" class="form-control">
                                <option value="0">Ana kategori</option>
                                @foreach($categories as $cat)
                                  <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                                @endforeach
                              </select>
                            </td>

                            <td>
                              <select id="inputState" class="form-control" name="status[]">
                                <option selected value="0">Passiv</option>
                                <option value="1">Active</option>
                              </select>
                            </td>

                            <td>
                                <a href="javascript:void(0)" class="btn btn-danger remove"><i class="material-icons">remove</i>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td><input type="submit" name="" value="Submit" class="btn btn-primary pull-right"></td>
                        </tr>
                    </tfoot>
                </table>
                      
                     
                  </form>
                </div>
              </div>
            </div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('.addRow').on('click', function(){
            addRow();
        });

        function addRow(){
            var tr = '<tr>'+
            '<td><input type="text" name="cat_name[]" class="form-control"></td>'+
            '<td><select name="category[]" class="form-control">'+
                '<option value="0">Ana kategori</option>'+
                    '@foreach($categories as $cat)'+
                        '<option value="{{$cat->id}}">{{$cat->cat_name}}</option>'+
                    '@endforeach'+
            '</select></td>'+
            '<td><select id="inputState" class="form-control" name="status[]">'+
                '<option selected value="0">Passiv</option>'+
                '<option value="1">Active</option>'+
                '</select> </td>'+
            '<td><a href="javascript:void(0)" class="btn btn-danger remove"><i class="material-icons">remove</i></a></td>'+
            '</tr>';
            $('tbody').append(tr);
        };


        $(document).on('click', '.remove', function(){
            var last = $('tbody tr').length;
            if(last==1){
                alert("no deleted one row");
            }else{
                $(this).parent().parent().remove();
            }
            
        });
    });
</script>  
@endsection