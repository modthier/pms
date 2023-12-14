@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Insuranc {{ __('body.pointOfSale') }}</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
<!-- Content Header (Page header) -->



<section class="col-lg-6 col-md-6 col-sm-12">
  <div class="card">    
      <div class="card-header">
          <div class="card-title">
            {{ __('body.scanner') }}
          </div>
      </div>

      <div class="card-body" style="padding-bottom: 4.6em;">
          
            {{ csrf_field() }} 
            <div class="form-group">
              <input type="number" name="scanner" id="barcode" class="form-control">
            </div>

           
    </div>
    </div>
 </section>

<section class="col-lg-6 col-md-6 col-sm-12">
  <div class="card">    
      <div class="card-header">
          <div class="card-title">
            {{ __('body.itemSelect') }}
          </div>
      </div>

      <div class="card-body">
          <form>
            {{ csrf_field() }} 
           
             <div class="form-group">
               <select class="form-control" style="width: 100%;"  id="stockId">
                  
                    <option></option>
                    
                  
                </select>
             </div>
               
             <div class="form-group">
              <button  id="ItemByName" type="button" class="btn btn-info">{{ __('body.addItem') }}</button>
             </div>
            
          </form>  
    </div>
    </div>
 </section>

   @if(session('errs'))
  <section class="col-lg-12">

    @foreach(session('errs') as $err)
    <div class="alert alert-danger" role="alert">
      {{ $err }}
    </div>
    @endforeach

  </section>
  @endif

 <section class="col-lg-12">
    <div class="card">    
     
      <form action="{{ route('insurancePointOfSale.store') }}" method="post">

        <div class="row p-3">
              

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>{{ __('body.paymentMethod') }}</label>
                      <select name="method_id" class="form-control select2" style="width: 100%;" required>
                          <option></option>
                          @foreach ($payments as $payment)
                              <option value="{{ $payment->id }}">{{ $payment->method }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-sm-6">
                <label>Insurance Companies</label>
                <div class="input-group">
                      <select name="company_id" id="company" 
                        class="form-control"  required>
                          <option></option>
                          @foreach ($companies as $company)
                              <option data-pst="{{ $company->deduct_rate }}" 
                              value="{{ $company->id }}">{{ $company->name }}</option>
                          @endforeach
                          
                      </select>
                  </div>
              </div>
        </div>

        {{ csrf_field() }} 
        
        <div class="card-body table-responsive p-0">
          <table class="table table-hovered">
              <thead>
                  <th>{{ __('body.tradeName') }}</th>
                  <th>{{ __('body.quantity') }}</th>
                  <th>{{ __('body.price') }}</th>
                  <th>Deduction Value</th>
                  <th>Deduction Rate</th>
                  <th>Sub Total</th>
                  <th>Actions</th>
              </thead>

              <tbody class="order_list">
                
              </tbody>
          </table>

          
            <h3 style="padding: .75rem 1.25rem;">{{ __('body.total') }} : <span class="total"></span> </span></h3>
            <h3 style="padding: .75rem 1.25rem;">Total Deduct : <span class="total_dedcut"></span> </span></h3>
            
            <input type="hidden" id="total_all" name="total">
            <input type="hidden" id="total_dedcut" name="total_dedcut">
        </div>
         <div class="card-footer">
          
              <button type="submit" id="orderBtn" disabled class="btn btn-primary btn-lg">{{ __('body.save') }}</button> 
          
         </div>
      </form>
           

    </div>
</section>




<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="incModal">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title text-danger" id="exampleModalLongTitle">Item Has tow Stock Pleas chose one</h5>
              <button type="button" id="clsBtn" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body p-0" id="loadForm">
              <table class="table table-hovered">
                  <thead>
                      <th>{{ __('body.tradeName') }}</th>
                      <th>Expire Date</th>
                      <th>Action</th>
                  </thead>

                  <tbody class="drug_list_modal">
                    
                  </tbody>
              </table>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" id="clsBtnFooter" data-dismiss="modal">Close</button>
              
          </div>
      </div>
  </div>
</div>


@endsection
