@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Stock</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('stocks.index') }}">Add Stock</a></li>
            </ol>
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
      <form action="{{ route('stocks.store') }}" method="post" id="drugsForm">
        {{ csrf_field() }} 

        
        <div class="card-body">
         
          <div class="row">

              
               <div class="col-sm-6">
                  <div class="form-group">
                      <label>Drug</label>
                      <select name="drug_id" id="drug_id" class="form-control sel" required style="width: 100%;">
                        <option></option>
                        @foreach ($drugs as $drug)
                        <option value="{{ $drug->id }}">{{   $drug->trade_name  }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>


              <div class="col-sm-6">
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
                        class="form-control"
                        value="{{ old('patch_number') }}">
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Barcode</label>
                      <input type="text" name="barcode" 
                        class="form-control"
                        value="{{ old('barcode') }}">
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
                      <select name="pst" id="profit_margin" class="form-control">
                       
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
                      <label>Unit Price</label>
                      <input type="text" name="unit_price" 
                        class="form-control" id="unit_price" 
                        value="{{ old('unit_price') }}">
                  </div>
              </div>




              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Total Price</label>
                      <input type="text" name="total_price" 
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
                      <input type="text" name="purchasing_price" 
                        class="form-control" id="purchasing_price" 
                        value="{{ old('purchasing_price') }}" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Selling Price Per Unit</label>
                      <input type="text" name="selling_price" 
                        class="form-control" id="selling_price" 
                        value="{{ old('selling_price') }}" required>
                  </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                    <label>Bonus percentage</label>
                    <input type="number" name="bonus_pst" 
                      class="form-control" id="bonus_pst" 
                        value="0" required>
                </div>
            </div>

              <div class="col-sm-6">
                <div class="form-group">
                    <label>Purchase Bonus</label>
                    <input type="text" name="bonus" 
                      class="form-control" id="bonus" 
                      value="0" required>
                </div>
            </div>

              

          </div>
        </div>
         <div class="card-footer">
          
              <input type="submit" value="Save" id="stock_submitBtn" class="btn btn-primary btn-lg">
          
         </div>
      </form>
           

    </div>
</section>

@endsection
