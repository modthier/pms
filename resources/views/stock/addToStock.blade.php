@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add To Existing Stock</h1>
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
          <a href="{{ route('stocks.index') }}" class="btn btn-primary">Back</a>
      </div>

      <div class="mb-2 p-3">
            <h4 class="text-primary">Stock Info</h4>
            <table class="table table-bordered">
              <tr>
                <td>{{ $stock->drug->trade_name }}</td>
                <td>{{ $stock->drug->generic_name }}</td>
              </tr>
              <tr>
                <td>Unites Per Package : {{ $stock->count_per_unit }}</td>
                <td>Patch Number : {{ $stock->patch_number }}</td>
              </tr>
              <tr>
                <td>Barcode : {{ $stock->barcode }}</td>
                <td>Expiry date : {{ $stock->exp }}</td>
              </tr>
              <tr>
                <td>Quantity Per Unit : {{ $stock->quantity_per_unit }}</td>
                <td>Profit Margin : {{ $stock->pst }}%</td>
              </tr>
            </table>
      </div>
      <form action="{{ route('stocks.updatAddedStock',$stock->id) }}" method="post">
        {{ csrf_field() }} 
        {{ method_field('PUT') }}
        
        <div class="card-body">

         
         
          <div class="row">

              <input type="hidden" value="{{ $stock->count_per_unit }}" id="count_per_unit_stock">

              <input type="hidden" value="{{ $stock->pst }}" id="profit_margin">

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Purchased quantity</label>
                      <input type="number" name="quantity" 
                        class="form-control" id="stock_quantity" required>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Unite Price</label>
                      <input type="number" name="unit_price" 
                        class="form-control" value="{{ $stock->purchasing_price }}"  id="unit_price" required>
                  </div>
              </div>




              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Total Price</label>
                      <input type="text" name="total_price" 
                        class="form-control" id="stock_total_price" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Quantity Per Unit</label>
                      <input type="number" name="quantity_per_unit" 
                        class="form-control" id="stock_quantity_per_unit" required>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Purchasing price Per Unit</label>
                      <input type="text" name="purchasing_price" 
                        class="form-control"  id="stock_purchasing_price" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Selling Price Per Unit</label>
                      <input type="text" name="selling_price" 
                        class="form-control" id="stock_selling_price" required>
                  </div>
              </div>

          </div>
        </div>
         <div class="card-footer">
          
              <input type="submit" value="Update" id="stock_submitBtn" class="btn btn-primary btn-lg">
          
         </div>
      </form>
           

    </div>
</section>

@endsection
