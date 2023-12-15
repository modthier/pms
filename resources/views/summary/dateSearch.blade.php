@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Summary Report</h1>
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
        <form action="{{ route('Summary.summaryByDates') }}" method="get">
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
              </div>

              <div class="form-group">
                  <input type="submit" value="Search" class="btn btn-success mt-2">
              </div>
          </form>
       </div>
    </div>
 </section>


 <section class="col-lg-12 mt-2">
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body table-responsive p-0">
            @if($total->totalPurchases > 0 && $total->totalSales > 0)
            <table class="table table-hover">
                <thead>
                    <th>Total Sales</th>
                    <th>Total Purchases</th>
                    <th>Total Expenses</th>
                    <th>Total Expired Stock</th>
                    <th>Total Stock Bonus</th>
                    <th>Total Discount</th>
                    <th>Profit Value</th>
                </thead>

                <tbody>
                
                 <tr>
                    <td>{{ number_format($total->totalSales,2) }}</td>
                    <td>{{ number_format($total->totalPurchases,2) }}</td>
                    <td>{{ number_format($expense_total,2) }}</td>
                    <td>{{ number_format($expired_total,2) }}</td>
                    <td>{{ number_format($stock_bonus,2) }}</td>
                    <td>{{ number_format($discount_total,2) }}</td>
                    <td>{{ number_format( (((($total->totalSales - $total->totalPurchases) - ($expense_total)) - $expired_total) - $discount_total) + $stock_bonus ,2) }}</td>
                 </tr>
                </tbody>
            </table>
           @else 
          <h1 class="text-danger text-center">Sorry No Data To be Shown</h1>
          @endif
        </div>
       


        <div class="card-footer">
         
        </div>



    </div>
</section>

@endsection