@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">edit Stock</h1>
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
      <form action="{{ route('stocks.update',$stock->id) }}" method="post" id="drugsForm">
        {{ csrf_field() }} 
        {{ method_field('PUT') }}
        
        <div class="card-body">
         
          <div class="row">
                 <input type="hidden" value="{{ $stock->pst }}" id="pst_db_value">

               <div class="col-sm-6">
                  <div class="form-group">
                      <label>Drug</label>
                      <select name="drug_id" id="drug_id" class="form-control select2" required style="width: 100%;">
                        <option></option>
                        @foreach ($drugs as $drug)
                        @if ($drug->id == $stock->drug_id)
                        <option value="{{ $drug->id }}" selected>{!! $drug->trade_name .' - '. $drug->generic_name !!}</option>
                                             
                        @else 
                        <option value="{{ $drug->id }}">{!! $drug->trade_name .' - '. $drug->generic_name !!}</option>
                        
                
                        @endif
                        @endforeach
                       </select>
                  </div>
              </div>

               <input type="hidden" value="{{ $stock->count_per_unit }}" id="old_count_per_unit">
               <div class="col-sm-6">
                  <div class="form-group">
                      <label>Unites Per Package</label>
                      <input type="number" name="count_per_unit" 
                        class="form-control" id="count_per_unit_edit"  value="{{ $stock->count_per_unit }}" required>
                  </div>
               </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Batch Number</label>
                      <input type="text" name="patch_number" 
                        class="form-control" value="{{ $stock->patch_number }}">
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Barcode</label>
                      <input type="text" name="barcode" 
                        class="form-control" value="{{ $stock->barcode }}" >
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Expiry date</label>
                      <input type="date" name="exp" 
                        class="form-control" value="{{ $stock->exp }}" required>
                  </div>
              </div>


               <div class="col-sm-6">
                  <div class="form-group">
                      <label>Profit Margin</label>
                      <select name="pst" id="profit_margin" class="form-control">
                       
                          <option value="0" @if($stock->pst == 0) selected @endif>0%</option>
                          <option value="10" @if($stock->pst == 10) selected @endif>10%</option>
                          <option value="20" @if($stock->pst == 20) selected @endif>20%</option>
                          <option value="30" @if($stock->pst == 30) selected @endif>30%</option>
                          <option value="40" @if($stock->pst == 40) selected @endif>40%</option>
                          <option value="50" @if($stock->pst == 50) selected @endif>50%</option>
                          <option value="60" @if($stock->pst == 60) selected @endif>60%</option>
                          <option value="70" @if($stock->pst == 70) selected @endif>70%</option>
                          <option value="80" @if($stock->pst == 80) selected @endif>80%</option>
                          <option value="90" @if($stock->pst == 90) selected @endif>90%</option>
                          <option value="100" @if($stock->pst == 100) selected @endif>100%</option>
                      </select>
                  </div>
              </div>

            

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Purchased quantity</label>
                      <input type="number" name="quantity" 
                        class="form-control" id="quantity"
                         value="{{ $stock->purchaseOrder->quantity }}" readonly required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Total Price</label>
                      <input type="number" name="total_price" 
                        class="form-control" id="stock_total_price_edit" 
                        value="{{ $stock->purchaseOrder->quantity * $stock->count_per_unit * $stock->purchasing_price }}" required>
                  </div>
              </div>
             
             <input type="hidden" id="old_stock_quantity_per_unit" 
             value="{{ $stock->quantity_per_unit}}">

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Quantity Per Unit</label>
                      <input type="number" name="quantity_per_unit" 
                        class="form-control" id="quantity_per_unit" 
                        value="{{ $stock->quantity_per_unit}}" readonly required>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Whole price Per Unit</label>
                      <input type="text" name="purchasing_price" 
                        class="form-control" id="purchasing_price" 
                         value="{{ $stock->purchasing_price}}" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Selling Price Per Unit</label>
                      <input type="text" name="selling_price" 
                        class="form-control" id="selling_price" 
                        value="{{ $stock->selling_price}}"  required>
                  </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                    <label>Bonus percentage</label>
                    <input type="number" name="bonus_pst" 
                      class="form-control" id="bonus" 
                      value="{{ $stock->bonus_pst }}"  required>
                </div>
            </div>

              <div class="col-sm-6">
                <div class="form-group">
                    <label>Purchase Bonus</label>
                    <input type="text" name="bonus" 
                      class="form-control" id="bonus" 
                      value="{{ $stock->bonus }}" required>
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
