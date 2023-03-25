@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Hourly Sales Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Hourly Sales Report</li>
            </ol>
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
              Hourly Sales Report
          </div>
      </div>
      <div class="card-body pt-0 pb-0">  
        <form action="{{ route('hourlySalesReport.DrugRequests') }}" method="get">
              
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                      <label>Select Date</label>
                      <input type="date" name="start_date" class="form-control" required>
                  </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                      <label>Start Time</label>
                      <input type="time" name="start_time" class="form-control" required>
                  </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                      <label>End Time</label>
                      <input type="time" name="end_time" class="form-control" required>
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

 <div class="col-lg-12">
            <!-- small box -->
        <div class="small-box bg-white">
          <div class="inner">
            <h3>
              @if($total)
              {{ number_format($total,2) }}
              @endif
            </h3>

            <p><strong>Hourly Total</strong></p>
          </div>
          
        </div>
 </div>

   

@endsection