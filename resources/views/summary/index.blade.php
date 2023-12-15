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

 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
  <!-- small box -->
      <div class="card bg-white">
        <div class="card-body">
        <div class="small-box">
      <div class="inner">
        <strong>Overall Summry</strong>
        <hr>
        @if($total->totalPurchases > 0 && $total->totalSales > 0)
        

        <h4>Total Sales : {{ number_format($total->totalSales,2) }}</h4>
        <h4>Total Purchases : {{ number_format($total->totalPurchases,2) }}</h4>

        <h4>Total Expenses : {{ number_format($expense_total,2) }}</h4>
        <h4>Total Expired Stock : {{ number_format($expired_total_all,2) }}</h4>
        <h4>Total discount  : {{ number_format($total_discount,2) }}</h4>
        <h4>Total Stock Bonus: {{ number_format($stock_bonus,2) }}</h4>

        <h4>Profit Value : {{ number_format( (( (($total->totalSales - $total->totalPurchases) - ($expense_total)) - $expired_total_all) - $total_discount) + $stock_bonus ,2) }}</h4>

        @else 
        <h4 class="text-danger text-center">Sorry No Data To be Shown</h4>
        @endif
      </div>

     </div>
        </div>
      </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 mt-2">
  <!-- small box -->
  <div class="card bg-white">
        <div class="card-body">
      <div class="small-box bg-white">
      <div class="inner">
        <strong>Summry Today</strong>
        <hr>
        @if($total_today->totalPurchases > 0 && $total_today->totalSales > 0)
        

        <h4>Total Sales : {{ number_format($total_today->totalSales,2) }}</h4>
        <h4>Total Purchases : {{ number_format($total_today->totalPurchases,2) }}</h4>

        <h4>Total Expenses : {{ number_format($expense_today,2) }}</h4>
        <h4>Total Expired Stock : {{ number_format($expired_total_today,2) }}</h4>
        <h4>Total discount : {{ number_format($discount_today,2) }}</h4>

        <h4>Profit Value : {{ number_format( ( ( ($total_today->totalSales - $total_today->totalPurchases) - ($expense_today)) - $expired_total_today) - $discount_today,2) }}</h4>
        @else 
        <h4 class="text-danger text-center">No Sales Yet Today</h4>
        @endif
      </div>

     </div>
     </div>
      </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 mt-2">
  <!-- small box -->
  <div class="card bg-white">
        <div class="card-body">
      <div class="small-box bg-white">
      <div class="inner">
        <strong>Summry This Week</strong>
        <hr>
        @if($total_week->totalPurchases > 0 && $total_week->totalSales > 0)
        

        <h4>Total Sales : {{ number_format($total_week->totalSales,2) }}</h4>
        <h4>Total Purchases : {{ number_format($total_week->totalPurchases,2) }}</h4>

        <h4>Total Expenses : {{ number_format($expense_week,2) }}</h4>
        <h4>Total Expired Stock : {{ number_format($expired_total_week,2) }}</h4>
        <h4>Total discount : {{ number_format($discount_week,2) }}</h4>
        

        <h4>Profit Value : {{ number_format( ((($total_week->totalSales - $total_week->totalPurchases) - ($expense_week)) - $expired_total_week) - $discount_week ,2) }}</h4>
        @else 
        <h4 class="text-danger text-center">No Sales Yet This Week</h4>
        @endif
      </div>

     </div>
     </div>
      </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 mt-2">
  <!-- small box -->
  <div class="card bg-white">
        <div class="card-body">
      <div class="small-box bg-white">
      <div class="inner">
        <strong>Summry This Month</strong>
        <hr>
        @if($total_month->totalPurchases > 0 && $total_month->totalSales > 0)
        

        <h4>Total Sales : {{ number_format($total_month->totalSales,2) }}</h4>
        <h4>Total Purchases : {{ number_format($total_month->totalPurchases,2) }}</h4>

        <h4>Total Expenses : {{ number_format($expense_month,2) }}</h4>
        <h4>Total Expired Stock : {{ number_format($expired_total_month,2) }}</h4>
        <h4>Total discount Stock : {{ number_format($discount_month,2) }}</h4>
        

        <h4>Profit Value : {{ number_format( ( (($total_month->totalSales - $total_month->totalPurchases) - ($expense_month)) - $expired_total_month) - $discount_month ,2) }}</h4>
        @else 
        <h4 class="text-danger text-center">No Sales Yet This Month</h4>
        @endif
      </div>

     </div>
     </div>
      </div>
</div>

 



@endsection