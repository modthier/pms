@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">All Payments</h1>
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
          <div class="card-title">
              Report Between Two Dates
          </div>
      </div>
      <div class="card-body">  
        <form action="{{ route('payments.search') }}" method="get">
              <div class="row">
                  <div class="col-lg-4">
                      <div class="form-group">
                          <label>Date From</label>
                          <input type="date" name="date_from" class="form-control">
                      </div>
                  </div>

                   <div class="col-lg-4">
                      <div class="form-group">
                          <label>Date To</label>
                          <input type="date" name="date_to" class="form-control">
                      </div>
                  </div>

                  <div class="col-lg-4">
                      <div class="form-group">
                          <label>Status</label>
                          <select name="status" required class="form-control">
                                <option></option>
                                <option value="0">Pendding</option>
                                <option value="1">Paid</option>
                                <option value="2">Canceled</option>
                          </select>
                        
                      </div>
                  </div>

              </div>

              <div class="form-group">
                  <input type="submit" value="Search" class="btn btn-success">
              </div>
          </form>
       </div>
    </div>
 </section>

 <section class="col-lg-12">
    <div class="card">
        <div class="card-header">
          <div class="card-title">
             <a href="{{ route('payments.create') }}" class="btn btn-primary">Add New</a>
          </div>
          <div class="card-tools">
              {{ $payments->links() }}
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          @if($payments->count() > 0)
            <table class="table table-hover">
                <thead>
                    <th>Beneficiary</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                    <th>Bank Account</th>
                    <th>Status</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  
                  @foreach ($payments as $payment)
                  <tr>
                   
                    <td>{{ $payment->beneficiary }}</td>
                    <td>@money($payment->amount,'BIF')</td>
                    <td>{{ $payment->due_date }}</td>
                    <td>{{ $payment->account->name }}</td>
                    <td>
                      @if($payment->status == 0)Pendding
                      @elseif($payment->status == 1)Paid
                      @elseif($payment->status == 2)Canceled
                      @endif
                    </td>
                   
                    <td>
                      @if($payment->status == 0)
                       <a class="btn btn-success" href="{{ route('payments.pay',$payment->id) }}">Change to Paid</a>
                       <a class="btn btn-dark" href="{{ route('payments.cancel',$payment->id) }}">Cancel</a>
                     
                      <a href="{{ route('payments.edit',$payment->id) }}" class="btn btn-warning">Edit</a>


                     <form id="payment_delete_{{ $payment->id }}" action="{{ route('payments.destroy',$payment->id) }}"
                       method="post" class="float-left mr-1">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger" onclick="event.preventDefault();
                       var r = confirm('are you sure ?');
                       if (r == true) {document.getElementById('offers_delete_{{ $payment->id }}').submit();}">Delete</button>
                      </form>
                       @endif
                    </td>
                  </tr>
                  @endforeach


                </tbody>
            </table>

             @else 
              <h1 class="text-danger text-center">No Payment were Added</h1>
             @endif

        </div>

        <div class="card-footer">
             {{ $payments->links() }}
        </div>



    </div>
</section>

@endsection
