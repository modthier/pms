@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Balance Insurance Invoice</h1>
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
            Invoice Details
        </div>
        <div class="card-body">
            <h5>Insurance Company : {{ $invoice->insurance->name }}</h5>
            <h5>Invoice Amount : {{ number_format($invoice->amount_due,2) }}</h5>
            <h5>Duration : {{ $invoice->date_from }} => {{ $invoice->date_to }}</h5>
            <h5></h5>
        </div>

    </div>
</section>

 <section class="col-lg-12">
    <div class="card">    
      <div class="card-header">
        <a href="{{ route('InsuranceInvoice.index') }}" class="btn btn-primary">Back</a>
      </div>
      <form action="{{ route('balanceInvoice.balanceInvoice',$invoice->id) }}" method="post">
        {{ csrf_field() }} 
         @method('PUT')
        <div class="card-body">
          <div class="row">

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Amount Paid</label>
                      <input type="number" name="amount_paid" 
                        class="form-control" required>
                  </div>
              </div>

          </div>
        </div>
         <div class="card-footer">
          
              <input type="submit" value="Balance Invoice" class="btn btn-primary btn-lg">
          
         </div>
      </form>
           

    </div>
</section>

@endsection
