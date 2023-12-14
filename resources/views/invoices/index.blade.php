@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Insurance Invoices</h1>
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
           Invoices Report By Date 
        </div>
    </div>
    <div class="card-body pt-0 pb-0">  
      <form action="{{ route('InsuranceInvoice.search') }}" method="get">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Date From</label>
                        <input type="date" name="date_from" class="form-control" required>
                    </div>
                </div>

                 <div class="col-lg-4">
                    <div class="form-group">
                        <label>Date To</label>
                        <input type="date" name="date_to" class="form-control" required>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Insurance Company</label>
                        <select name="insurance_company_id" class="form-control" required>
                            <option></option>
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
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
            <strong>  Summary ({{ \Carbon\Carbon::now()->startOfYear() }}) => ({{ \Carbon\Carbon::now()->endOfYear() }})</strong>
          </div>
          <div class="card-body p-0">
            <table class="table table-hover">
                  <thead>
                    <th>Insurance Company</th>
                    <th>Amount Due</th>
                    <th>Amount Paid</th>
                    <th>Remaining</th>
                  </thead>
                  <tbody>
                        @foreach($summary as $item)
                        <tr>
                          <td>{{ $item->name }}</td>
                          <td>{{ number_format($item->amount_due,2) }}</td>
                          <td>{{ number_format($item->amount_paid,2) }}</td>
                          <td>{{ number_format($item->amount_due - $item->amount_paid,2) }}</td>
                        </tr>
                        @endforeach

                  </tbody>
              
            </table>
          </div>
      
  </div>
</section>


<section class="col-lg-12">
  <div class="card">
          <div class="card-header">
            
          </div>
          <div class="card-body p-0">
            <table class="table table-hover">
                  <thead>
                    <th>Insurance Company</th>
                    <th>Duration (yyyy-mm-dd)</th>
                    <th>Amount Due</th>
                    <th>Amount Paid</th>
                    <th>Remaining</th>
                    <th>Center Fees (5%)</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                          <td>{{ $invoice->insurance->name }}</td>
                          <td><strong>({{ $invoice->date_from }})</strong> =>  <strong>({{ $invoice->date_to  }})</strong></td>
                          <td>{{ number_format($invoice->amount_due,2) }}</td>
                          <td>{{ number_format($invoice->amount_paid,2) }}</td>
                          <td>{{ number_format($invoice->amount_due - $invoice->amount_paid,2) }}</td>
                          <td>{{ number_format(($invoice->amount_due * 0.05),2) }}</td>
                          <td>
                              <a href="{{ route('InsuranceInvoice.editBalance',$invoice->id) }}" class="btn btn-success btn-sm mb-2">
                                  Balance Invoice
                              </a>

                              <a href="{{ route('InsuranceInvoice.edit',$invoice->id) }}" class="btn btn-primary btn-sm">
                                Edit
                            </a>
                          </td>
                        </tr>
                        @endforeach

                  </tbody>
              
            </table>
          </div>
          <div class="card-footer">
               {{ $invoices->links() }}
          </div>
      
  </div>
</section>




@endsection
