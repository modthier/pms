@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Insurance Sales Report</h1>
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
             Export Report or Create Invoice
          </div>
      </div>
      <div class="card-body pt-0 pb-0">  
        <form action="{{ route('pos.insuranceReport') }}" method="get">
              <div class="row">
                  <div class="col-lg-6">
                      <div class="form-group">
                          <label>Date From</label>
                          <input type="date" name="date_from" class="form-control" required>
                      </div>
                  </div>

                   <div class="col-lg-6">
                      <div class="form-group">
                          <label>Date To</label>
                          <input type="date" name="date_to" class="form-control" required>
                      </div>
                  </div>

                  <div class="col-lg-6">
                      <div class="form-group">
                          <label>Insurance Company</label>
                          <select name="insurance_company_id" class="form-control" required>
                              <option value=""></option>
                              @foreach($companies as $company)
                              <option value="{{ $company->id }}">{{ $company->name }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                        <label>Action</label>
                        <select name="action" class="form-control" required>
                            <option value=""></option>
                            <option value="export">Export</option>
                            <option value="create_invoice">Create Invoice</option>
                        </select>
                    </div>
                </div>
              </div>

              <div class="form-group">
                  <input type="submit" value="Execute" class="btn btn-success">
              </div>
          </form>
       </div>
    </div>
 </section>

 <section class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <strong>Summary</strong>
            </div>
          </div>
            <div class="card-body p-0">
              <table class="table table-hover">
                 <thead>
                    <th>Insurance Company</th>
                    <th>Deduct Value Total</th>
                    <th>Added Value</th>
                    <th>Actual Total</th>
                    <th>Claim Total</th>
                  </thead>
                    <tbody>
                          @foreach($summary as $sum)
                          <tr>
                            <td>{{ $sum->name }}</td>
                            <td>{{ number_format($sum->deduct_total,2) }}</td>
                            <td>{{ number_format($sum->added_value) }}</td>
                            <td>{{ number_format($sum->actual_total,2) }}</td>
                            <td>{{ number_format( ($sum->actual_total - $sum->deduct_total),2) }}</td>
                            
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
            
            

            <table class="table table-hover table-responsive">
                <thead>
                    <th>Created By</th>
                    <th>Insurance Company</th>
                    <th>Deduct Rate</th>
                    <th>Deduct Value</th>
                    <th>Claim</th>
                    <th>Actual Price</th>
                    <th>Date</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($orders as $order)
                  <tr>
                    <td>{{ $order->username }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->deduct_rate }}%</td>
                    <td>{{ number_format($order->deduct_value,2) }}</td>
                    <td> {{ number_format($order->claim,2) }}</td>
                    <td>{{ number_format($order->total_price,2) }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                     
                      <a href="{{ route('insurancePointOfSale.show',$order->id) }}" class="btn btn-success float-left mr-1 mb-1"><span class="fas fa-book-open"></span></a>
                      

                      
                      <a href="{{ route('DrugRequests.edit',$order->id)  }}" class="btn btn-primary float-left mr-1 mb-1"><span class="fas fa-edit"></span></a>
                     

                      @can('can_show')
                      <form action="{{ route('DrugRequests.destroy',$order->id) }}"
                       method="post" id="delete_order_{{ $order->id }}" class="float-left mr-1">
                        @csrf

                        {{ method_field('DELETE') }}

                         <button type="submit" class="btn btn-danger mb-1" onclick="event.preventDefault();
                                      var r = confirm('are you sure ?');
                                      if (r == true) {document.getElementById('delete_order_{{ $order->id }}').submit();}">{{ __('body.delete') }}</button>
                      </form>
                      @endcan


                       
                      

                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
          
        </div>

        <div class="card-footer">
          {{ $orders->links() }}
        </div>



    </div>
</section>
  
@endsection
