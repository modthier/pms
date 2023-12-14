@extends('admin.layouts.sneat')



@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('body.salesReportDetails') }}</h1>
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
           <a href="{{ route('insurancePointOfSale.create') }}" class="btn btn-primary">Back</a>
         </div>
        
      </div><hr>
        <div  class="card-body table-responsive p-0">

            <table class="table table-hover">
                <thead>
                    <th>{{ __('body.tradeName') }}</th>
                    <th>Actual Price</th>
                    <th>Deduction Value</th>
                    <th>Deduction Rate</th>
                    <th>{{ __('body.quantity') }}</th>
                    <th>{{ __('body.totalPrice') }}</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($orders->stock as $one)
                  <tr>
                    <td>{{ $one->drug->trade_name }}</td>
                    <td>{{ $one->pivot->price  }} </td>
                    <td>{{$one->pivot->price *  ($orders->insurance()->first()->pivot->deduct_rate/100)}} </td>
                    <td>{{$orders->insurance()->first()->pivot->deduct_rate}}</td>
                    <td>{{ $one->pivot->quantity }}</td>
                    <td>{{$one->pivot->price *  ($orders->insurance()->first()->pivot->deduct_rate/100)}} </td>
                    <td>
                      <a href="{{ route('ReturnedItems.returnInc',$one->pivot->id) }}" class="btn btn-danger btn-sm"><span class="fas fa-arrow-circle-left"></span></a>
                    </td>

                   
                  </tr>
                  @endforeach
                </tbody>
            </table>
           
            <h3 class="pl-3 mt-3">Total : {{ number_format($orders->insurance()->first()->pivot->deduct_value,2) }}</h3>
        </div>

        <div class="card-footer">
          
          
        </div>



    </div>
</section>



<section class="col-lg-5 mt-3">
    <div class="card">
      <div class="card-header">
       Print Area
      </div>
        <div id="receiptArea" class="card-body table-responsive p-0">
            <p class="text-center"><strong>{{ $setting->pharmacy_name }}</strong></p>
           

            
            <table class="table-sm table-bordered p-0">
               
               
                    <th>{{ __('body.product') }}</th>
                    <th>Actual Price</th>
                    <th>Deduction Price</th>
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
                      <td>{{$one->pivot->price *  ($orders->insurance()->first()->pivot->deduct_rate/100)}} 
                      </td>

                    <td>{{ $one->pivot->quantity }}</td>
                   
                  </tr>
                  @endforeach
                </tbody>
            </table>
  
            
            <div class="mt-4">
              Actual Total Price : {{ number_format($orders->total_price,2) }}

            </div>
            <div class="mt-4">
              Deduction Total Price : {{ number_format($orders->insurance()->first()->pivot->deduct_value,2) }}
            </div>

            <div>{{ __('body.printedBy') }} : {{ $orders->user->name }}</div>
            <div><svg class="barcode"
                          jsbarcode-value="{{ $orders->uniqid }}"
                          jsbarcode-textmargin="0"
                          jsbarcode-width="1"
                          >
                </svg>
            </div>
            <div class="mb-4">Created at : {{ $orders->created_at }}</div>
            
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
