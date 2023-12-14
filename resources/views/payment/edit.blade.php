@extends('admin.layouts.sneat')

@section('starter')

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Update Payment</h1>
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
      <form action="{{ route('payments.update',$payment->id) }}" method="post">
        {{ csrf_field() }} 
        {{ method_field('PUT') }}
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Bank Account</label>
                      <select name="account_id" required class="form-control">
                          <option></option>
                          @foreach($accounts as $account)
                            <option @if($payment->account->id == $account->id) selected @endif value="{{ $account->id }}">{{ $account->name }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Beneficiary</label>
                      <input type="text" name="beneficiary" class="form-control"
                      value="{{ $payment->beneficiary }}" required>
                  </div>
              </div>

              

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Check Number</label>
                      <input type="number" name="check_number" class="form-control" 
                      value="{{ $payment->check_number }}" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Amount</label>
                      <input type="number" name="amount" class="form-control"
                      value="{{ $payment->amount }}" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Due Date</label>
                      <input type="date" name="due_date" class="form-control" 
                      value="{{ $payment->due_date }}" required>
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
