@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Drug</h1>
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
      <form action="{{ route('drugs.store') }}" method="post">
        {{ csrf_field() }} 
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Trade Name</label>
                      <input type="text" id="trade_name" name="trade_name" 
                        class="form-control" required>
                        <span id="trade_name_error"></span>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Generic Name</label>
                      <input type="text" name="generic_name" 
                        class="form-control" required>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Drug Type</label>
                      <select class="form-control"  name="item_type_id">
                        <option></option>
                        @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->type }}</option>
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
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>

              
              
              

          </div>
        </div>
         <div class="card-footer">
          
              <input type="submit" value="Save" class="btn btn-primary btn-lg">
          
         </div>
      </form>
           

    </div>
</section>

@endsection
