@extends('admin.layouts.sneat')

@section('starter')

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Payment</h1>
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
      <form action="{{ route('payments.store') }}" method="post">
        {{ csrf_field() }} 
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Bank Account</label>
                      <select name="account_id" required class="form-control">
                          <option></option>
                          @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Beneficiary</label>
                      <input type="text" name="beneficiary" class="form-control" required>
                  </div>
              </div>

              

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Check Number</label>
                      <input type="number" name="check_number" class="form-control" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Amount</label>
                      <input type="number" name="amount" class="form-control" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Due Date</label>
                      <input type="date" name="due_date" class="form-control" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Choose Status</label>
                      <select name="status" required class="form-control">
                          <option></option>
                          <option value="0">Pendding</option>
                          <option value="1">Paid</option>
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
