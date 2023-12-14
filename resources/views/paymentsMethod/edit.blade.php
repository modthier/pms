@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Update Payment Method</h1>
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
      <form action="{{ route('paymentMethod.update',$payment) }}" method="post">
        {{ csrf_field() }} 
        {{ method_field('PUT') }} 
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Payment Method</label>
                      <input type="text" name="method" 
                        class="form-control" value="{{ $payment->method }}" required>
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
