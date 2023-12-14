@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header mt-3">
        <div class="container-fluid">
          
        <div  class="d-flex justify-content-between align-items-center">
          <div>
            <h1 class="m-0 text-dark">Sales Report</h1>
          </div><!-- /.col -->
          <div>
           <button id="filter" class="btn btn-primary float-sm-right">Show Filters</button>
          </div><!-- /.col -->
          </div>
        </div>
       
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
<!-- Content Header (Page header) -->

  
<section class="row mb-3">
 <section class="col-lg-5 filters">
    <div class="card">
      <div class="card-header">
          <div class="card-title">
              Report Between Two Dates
          </div>
      </div>
      <div class="card-body pt-0 pb-0">  
        <form action="{{ route('salesBetween.DrugRequests') }}" method="get">
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
                  <input type="submit" value="Search" class="btn btn-success mt-2 mb-2">
              </div>
          </form>
       </div>
    </div>
 </section>

 <section class="col-lg-3 filters">
    <div class="card">
      <div class="card-header">
          <div class="card-title">
              Search By Receipt Number
          </div>
      </div>
      <div class="card-body pt-0 pb-0">  
        <form action="{{ route('receiptNumber.DrugRequests') }}" method="get">
              
            <div class="form-group">
                <label>Receipt Number</label>
                <input type="text" name="receipt_number" class="form-control" placeholder="Put the curser here" required>
            </div>
                

            <div class="form-group">
                  <input type="submit" value="Search" class="btn btn-success mt-2 mb-2">
            </div>
          </form>
       </div>
    </div>
 </section>

 <section class="col-lg-4 filters">
    <div class="card">
      <div class="card-header">
          <div class="card-title">
              Search By Trade Name
          </div>
      </div>
      <div class="card-body pt-0 pb-0">  
        <form action="{{ route('tradeName.DrugRequests') }}" method="get">
              
            <div class="form-group">
                <label>Trade Name</label>
                <input type="text" name="trade_name" class="form-control" required>
            </div>
                

            <div class="form-group">
                  <input type="submit" value="Search" class="btn btn-success mt-2 mb-2">
            </div>
          </form>
       </div>
    </div>
 </section>
  <div class="mt-3"></div>

 <section class="col-lg-12 filters">
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
                  <input type="submit" value="Search" class="btn btn-success mt-2 mb-2">
            </div>
          </form>
       </div>
    </div>
 </section>
 </section>

 @can('can_access')
 <div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <h5 class="mb-3"> Total Sales My Payment Method </h5>
      <table class="table">
        <th>Payment Method</th>
        <th>Items</th>
        <th>Total</th>
        @foreach($total_by_payments as $total_pay)
         <tr>
           <td>{{ $total_pay->method }}</td>
           <td>{{ $total_pay->total_items }}</td>
           <td>{{ number_format($total_pay->total_price,2) }}</td>
         </tr>
        @endforeach
      </table>
      
    </div>
    
  </div>
</div>
@endcan


 <div class="col-lg-4 col-md-4 col-sm-12">
            <!-- small box -->
        <div class="small-box bg-white">
          <div class="inner">
            <h5>
              @if($total_today)
              {{ number_format($total_today,2) }}
              @endif
            </h5>

            <p><strong>Total Today</strong></p>
          </div>
          
        </div>
 </div>

   
@can('can_show')         
 <div class="col-lg-4 col-md-4 col-sm-12">
            <!-- small box -->
        <div class="small-box bg-white">
          <div class="inner">
            <h5>
              @if($total_week)
              {{ number_format($total_week ,2) }}
             
              @endif
            </h5>
           

            <p><strong>Total Week</strong></p>
          </div>
          
        </div>
 </div>

 <div class="col-lg-4 col-md-4 col-sm-12">
            <!-- small box -->
        <div class="small-box bg-white">
          <div class="inner">
            <h5>
              @if($total_month)
              {{ number_format($total_month ,2) }}
             
              @endif
            </h5>
            

            <p><strong>Total Month</strong></p>
          </div>
          
          
        </div>
 </div>
 @endcan

 <section class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
            @can('can_access')

            <h5>All Time Total Sales:   
              @if($total)
              {{ number_format($total,2) }}
            
              @endif
            </h5>
            </div>
            @endcan
        </div>
        <div class="card-body table-responsive p-0">
            @if($orders)
            @if($orders->count() > 0)
            <div class="p-2">
            
              <a href="{{ route('drugRequest.export') }}" class="btn btn-primary">{{ __('body.exportToExcel') }}</a>
            </div>

            <table class="table table-hover">
                <thead>
                    <th>{{ __('body.createdBy') }}</th>
                    <th>{{ __('body.totalPrice') }}</th>
                    <th>Items Sold</th>
                    <th>{{ __('body.discount') }}</th>
                    <th>{{ __('body.paymentMethod') }}</th>
                    <th>Date</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($orders as $order)
                  <tr>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->total_price}}</td>
                    <td>{{ $order->total_items }}</td>
                    <td>{{ number_format($order->discount,2) }}</td>
                    <td>
                      @if($order->paymentMethod)  
                      {{ $order->paymentMethod->method }}
                      @endif
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y h:i:s A') }}</td>
                    <td>
                     
                      <a href="{{ route('DrugRequests.show',$order->id) }}" class="btn btn-success float-left mr-1 mb-1"><span class="fas fa-book-open"></span></a>
                      

                      
                      <a href="{{ route('DrugRequests.edit',$order->id)  }}" class="btn btn-primary float-left mr-1 mb-1"><span class="fas fa-edit"></span></a>
                     

                      @can('can_show')
                      <form action="{{ route('DrugRequests.destroy',$order->id) }}"
                       method="post" id="delete_order_{{ $order->id }}" class="float-left mr-1">
                        @csrf

                        {{ method_field('DELETE') }}

                         <button type="submit" class="btn btn-danger mb-1" onclick="event.preventDefault();
                                      var r = confirm('are you sure ?');
                                      if (r == true) {document.getElementById('delete_order_{{ $order->id }}').submit();}"><span class="fas fa-trash-alt"></span></button>
                      </form>
                      @endcan


                       <a href="{{ route('ReturnedItems.returnOrder',$order->id)  }}" class="btn btn-warning float-left mr-1 mb-1"><span class="fas fa-arrow-circle-left"></span></a>
                      

                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
            @else 
              <h3 class="text-center text-danger">No Sales Yet</h3>
            @endif
            @endif
        </div>

        <div class="card-footer">
          {{ $orders->links() }}
        </div>



    </div>
</section>
  <script type="text/javascript">
    JsBarcode(".barcode").init();
  </script>
  <script type="text/javascript" src="{{ asset('js/slide.js') }}" defer></script>
@endsection
