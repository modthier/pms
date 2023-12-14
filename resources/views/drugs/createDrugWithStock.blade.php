@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Drug With Stock</h1>
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
      <form action="{{ route('DrugWithStock.store') }}" method="post" id="drugsForm">
        {{ csrf_field() }} 

        <h3 class="text-center mt-2">Drug Information</h3>
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Trade Name</label>
                      <input type="text" id="trade_name" name="trade_name" 
                        class="form-control" 
                        value="{{ old('trade_name') }}" required>
                        <span id="trade_name_error"></span>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Generic Name</label>
                      <input type="text" name="generic_name" 
                        class="form-control" 
                        value="{{ old('generic_name') }}" required>
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

          <h3 class="text-center mt-2">Stock Information</h3>
          <div class="row">

            <div class="col-sm-12">
                  <div class="form-group">
                      <label>Unites Per Package</label>
                      <input type="number" name="count_per_unit" 
                        class="form-control" id="count_per_unit"  value="1" required>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Batch Number</label>
                      <input type="text" name="patch_number" 
                        class="form-control" value="{{ old('patch_number') }}">
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Barcode</label>
                      <input type="text" name="barcode" 
                        class="form-control" 
                        value="{{ old('barcode') }}" >
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Expiry date</label>
                      <input type="date" name="exp" 
                        class="form-control" 
                        value="{{ old('exp') }}" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Profit Margin</label>
                      <select name="profit_margin" id="profit_margin" class="form-control">
                          
                          <option value="0">0%</option>
                          <option value="10">10%</option>
                          <option value="20">20%</option>
                          <option value="30">30%</option>
                          <option value="40">40%</option>
                          <option value="50">50%</option>
                          <option value="60">60%</option>
                          <option value="70">70%</option>
                          <option value="80">80%</option>
                          <option value="90">90%</option>
                          <option value="100">100%</option>
                      </select>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Purchased quantity</label>
                      <input type="number" name="quantity" 
                        class="form-control" id="quantity"
                        value="{{ old('quantity') }}" required>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Unite Price</label>
                      <input type="number" name="unit_price" 
                        class="form-control" id="unit_price" 
                        >
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Total Price</label>
                      <input type="number" name="total_price" 
                        class="form-control" id="total_price" 
                        value="{{ old('total_price') }}" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Quantity Per Unit</label>
                      <input type="number" name="quantity_per_unit" 
                        class="form-control" id="quantity_per_unit" 
                        value="{{ old('quantity_per_unit') }}" required>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Whole price Per Unit</label>
                      <input type="number" name="purchasing_price" 
                        class="form-control" id="purchasing_price" 
                        value="{{ old('purchasing_price') }}" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Selling Price Per Unit</label>
                      <input type="number" name="selling_price" 
                        class="form-control" id="selling_price" 
                        value="{{ old('selling_price') }}" required>
                  </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                    <label>Insurance Selling Price Per Unit</label>
                    <input type="number" name="insurance_selling_price" 
                      class="form-control"  
                      value="{{ old('insurance_selling_price') }}" required>
                </div>
            </div>

          </div>
        </div>
         <div class="card-footer">
          
              <input type="submit" value="Save" id="submitBtn" class="btn btn-primary btn-lg">
          
         </div>
      </form>
           

    </div>
</section>

@endsection
