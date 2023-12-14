@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('body.dash') }}</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



@endsection

@section('content')
	<div class="col-lg-12 mb-3">
		<div class="row">
			 <div class="col-lg-3 col-md-3 col-sm-12">
            <!-- small box -->
        <div class="card bg-warning">
          <div class="card-body p-0">
            <div class="small-box p-2">
            <div class="inner">
              <h3>{{ $drugCount }}</h3>

              <p>{{ __('body.drugs') }}</p>
            </div>
            
            </div>
          </div>
        </div>
    </div>

    @can('can_show')
    <div class="col-lg-3 col-md-3 col-sm-12">
            <!-- small box -->
        <div class="card bg-info">
          <div class="card-body p-0">
            <div class="small-box p-2">
              <div class="inner">
                <h3>{{ $staffCount }}</h3>

                <p>{{ __('body.staff') }}</p>
              </div>
              
            </div>
          </div>
        </div>
    </div>
    @endcan

    <div class="col-lg-3 col-md-3 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $stockCount }}</h3>

                <p>{{ __('body.stock') }}</p>
              </div>
              
            </div>
   </div>


   @can('can_show')
   <div class="col-lg-3 col-md-3 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $soldCount }}</h3>

                <p>Sold Items</p>
              </div>
              
            </div>
   </div>
   @endcan
   
		</div>
	</div>
  
   <section class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Due to Be Expired Items ({{ $homeStocks->count() }})
                </div>
            </div>
            <div class="card-body table-responsive p-0">

                <table class="table table-hover">
                    <thead>

                    <th>{{ __('body.tradeName') }}</th>
                    <th>{{ __('body.quantity') }}</th>
                    <th>{{ __('body.exp') }}</th>
                    <th>Remainning Month</th>
                    </thead>

                    <tbody>
                    @foreach ($homeStocks as $stock)
                        
                        <tr>
                       

                            <td>{{ $stock->trade_name }}</td>
                            <td>{{ $stock->quantity_per_unit }}</td>
                            <td>{{ $stock->exp }}</td>
                            <td>{{ $stock->rem }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <div class="card-footer">
                {{ $homeStocks->links() }}
            </div>



        </div>
    </section>
    @can('can_show')
    <section class="col-lg-6">
       <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Due to Pay ({{ $homePayment->count() }})
                </div>
            </div>
            <div class="card-body table-responsive p-0">
            @if($homePayment->count() > 0)
            <table class="table table-hover">
                <thead>
                    <th>Beneficiary</th>
                    <th>Amount</th>
                    <th>Due Date</th>

                </thead>

                <tbody>
                  
                  @foreach ($homePayment as $h)
                  <tr>
                   
                    <td>{{ $h->beneficiary }}</td>
                    <td>{{ $h->amount }}</td>
                    <td>{{ $h->due_date }}</td>
                  </tr>
                  @endforeach


                </tbody>
            </table>

             @else 
              <h1 class="text-danger text-center">No Due Payment</h1>
             @endif
          </div>
          <div class="card-footer">
            
          </div>
        </div>
    </section>
    @endcan

@endsection
