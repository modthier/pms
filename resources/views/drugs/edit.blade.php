@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Update Drug</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
<!-- Content Header (Page header) -->

 <section class="col-lg-12">
    <div class="card">   
      <div class="card-header">
         <a href="{{ route('drugs.index') }}" class="btn btn-primary">Back</a>
      </div> 
      <form action="{{ route('drugs.update',$drug->id) }}" method="post">
        {{ csrf_field() }} 

        {{ method_field('PUT') }}
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Trade Name</label>
                      <input type="text" id="trade_name" name="trade_name" 
                        class="form-control" 
                        value="{{ $drug->trade_name}}" required>
                        <span id="trade_name_error"></span>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Generic Name</label>
                      <input type="text" name="generic_name" 
                        class="form-control" 
                        value="{{ $drug->generic_name}}"  required>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Drug Type</label>
                      <select class="form-control"  name="item_type_id">
                        <option></option>
                        @foreach ($types as $type)
                          @if($drug->item_type_id == $type->id)
                          <option value="{{ $type->id }}" selected>{{ $type->type }}</option>

                          @else 
                          <option value="{{ $type->id }}">{{ $type->type }}</option>
                          @endif
                        @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Drug Unit</label>
                      <select class="form-control"  name="unit_id">
                        <option></option>
                        @foreach ($units as $unit)
                         @if($drug->unit_id == $unit->id)
                          <option value="{{ $unit->id }}" selected>{{ $unit->name }}</option>

                         @else 
                          <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                         @endif
                        @endforeach
                      </select>
                  </div>
              </div>
              

          </div>
        </div>
         <div class="card-footer">
          
              <input type="submit" value="Update" class="btn btn-primary btn-lg">
          
         </div>
      </form>
           

    </div>
</section>

@endsection
