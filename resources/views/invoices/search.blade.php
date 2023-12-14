@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Invoices Search Result</h1>
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
            
          </div>
          <div class="card-body p-0">
            @if($search->count() > 0)
            <table class="table table-hover">
                  <thead>
                    <th>Insurance Company</th>
                    <th>Duration (yyyy-mm-dd)</th>
                    <th>Amount Due</th>
                    <th>Amount Paid</th>
                    <th>Remaining</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                        @foreach($search as $item)
                        <tr>
                          <td>{{ $item->insurance->name }}</td>
                          <td><strong>({{ $item->date_from }})</strong> =>  <strong>({{ $item->date_to  }})</strong></td>
                          <td>{{ number_format($item->amount_due,2) }}</td>
                          <td>{{ number_format($item->amount_paid,2) }}</td>
                          <td>{{ number_format($item->amount_due - $item->amount_paid,2) }}</td>
                          <td>
                              <a href="" class="btn btn-success">Balance Invoice</a>
                          </td>
                        </tr>
                        @endforeach

                  </tbody>
              
            </table>
            @else 
            <h3 class="text-danger">No Invoice match your search</h3>
            @endif
          </div>
      
  </div>
</section>




@endsection
