@extends('admin.app')



@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('body.salesReportDetails') }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">{{ __('body.salesReportDetails') }}</li>
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
        <div class="float-left">
          <a href="{{ route('DrugOrders.create') }}" class="btn btn-primary">Back</a>
          <a href="{{ route('DrugRequests.index') }}" class="btn btn-success">Return to report</a>
        </div>
        <div class="float-right">
          <a href="{{ route('order.showAddItem',$orders->id) }}" class="btn btn-primary">Add Item</a>
        </div>
      </div>
        <div  class="card-body table-responsive p-0">
            
            <table class="table table-hover">
                <thead>
                    <th>{{ __('body.tradeName') }}</th>
                    <th>{{ __('body.unitPrice') }}</th>
                    <th>{{ __('body.discount') }}</th>
                    <th>{{ __('body.quantity') }}</th>
                    <th>{{ __('body.totalPrice') }}</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($orders->stock as $one)
                  <tr>
                    <td>{{ $one->drug->trade_name }}</td>
                    <td>
                        {{ ($one->pivot->price)  }}     
                    </td>
                    <td>{{$one->pivot->discount}} </td>
                    <td>{{ $one->pivot->quantity }}</td>
                    <td>
                       {{ number_format(($one->pivot->quantity *  $one->selling_price) - $one->pivot->discount,2)  }}
                    
                    </td>
                    <td>
                      <a href="{{ route('drugOrder.ShowEditItem',$one->pivot->id) }}" class="btn btn-warning">Edit</a>
                      <a href="{{ route('ReturnedItems.returnItem',$one->pivot->id) }}" class="btn btn-danger">Return Item</a>
                    </td>

                   
                  </tr>
                  @endforeach
                </tbody>
            </table>
            <h3 class="pl-3 mt-3">Total : {{ number_format($orders->total_price,2) }}</h3>
        </div>

        <div class="card-footer">
          
          
        </div>



    </div>
</section>



<section class="col-sm-4 col-md-4 col-lg-4">
    <div class="card">
      <div class="card-header">
       Print Area
      </div>
        <div id="receiptArea" class="card-body table-responsive p-0 pl-3">
            <p style="font-weight: bold;"><strong>{{ $setting->pharmacy_name }}</strong></p>
           

            
            <table class="table table-bordered table-responsive">
               
               
                    <th>{{ __('body.product') }}</th>
                    <th>{{ __('body.rprice') }}</th>
                    <th>{{ __('body.quantity') }}</th>
               
                <tbody>
                  @foreach ($orders->stock as $one)
                  <tr>
                    <td>{{ $one->drug->trade_name }}</td>
                    <td>@if($one->pivot->price > 0)
                       {{ number_format($one->pivot->price,2) }}
                      @else 
                         {{ number_format($one->pivot->quantity *  $one->selling_price,2) }}
                      @endif</td>
                    <td>{{ $one->pivot->quantity }}</td>
                   
                  </tr>
                  @endforeach
                </tbody>
            </table>
  
            
            <div class="mt-4">
              {{ __('body.total') }} : {{ number_format($orders->total_price,2) }}
            </div>

            <div>{{ __('body.printedBy') }} : {{ $orders->user->name }}</div>
            <div><svg class="barcode"
                          jsbarcode-value="{{ $orders->uniqid }}"
                          jsbarcode-textmargin="0"
                          jsbarcode-width="1"
                          >
                </svg>
            </div>
            <span>Created at : {{ $orders->created_at }}</span>
            
        </div>

        <div class="card-footer">
          
          <button id="printReceipt" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
        </div>



    </div>
</section>
<script type="text/javascript">
    JsBarcode(".barcode").init();
  </script>
@endsection
