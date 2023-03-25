@extends('admin.app')

@section('starter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('body.PurchaseOrders') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">{{ __('body.PurchaseOrders') }}</li>
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
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-12">
                        <form  action="{{ route('PurchaseOrders.search') }}" method="get">

                      <div class="input-group">
                        <input class="form-control" id="input2-group2" type="search" name="q"  placeholder="{{ __('body.search') }}">
                        <span class="input-group-append">
                          <button class="btn btn-primary" type="submit">{{ __('body.search') }}</button>
                        </span>
                      </div>

                       </form>
                    </div>
                   </div>
                </div>
        </div>
</section>

<div class="col-lg-6 col-md-6 col-sm-12">
                <!-- small box -->
    <div class="small-box bg-white box-shadow">
      <div class="inner">
        @if($total_price)
        <h3>{{ number_format($total_price,2) }} </h3>
       
        @endif

        <p><strong> {{ __('body.wholePrice') }} </strong></p>
      </div>
      
    </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12">
                <!-- small box -->
    <div class="small-box bg-white box-shadow">
      <div class="inner">
        @if($sum)
        <h3>{{ number_format($sum,2) }}</h3>
       
        @endif

        <p><strong> {{ __('body.retailPrice') }} </strong></p>
      </div>
      
    </div>
</div>

    
    <section class="col-lg-12">
        <div class="card">
            <div class="card-header">
                 <a href="{{ route('po.export') }}" class="btn btn-success">{{ __('body.exportToExcel') }}</a>
                 <a href="{{ route('po.exportDetails') }}" class="btn btn-primary">{{ __('body.exportDetails') }}</a>
            </div>
           
            <div class="card-body table-responsive p-0">
                @if($pos)
                @if($pos->count() > 0)
                <table class="table table-hover">
                    <thead>

                    <th>{{ __('body.tradeName') }}</th>
                    <th>{{ __('body.genericName') }}</th>
                    <th>{{ __('body.totalPrice') }}</th>
                    <th>{{ __('body.quantity') }}</th>
                    <th>{{ __('body.createdBy') }}</th>
                    </thead>

                    <tbody>
                    @foreach ($pos as $po)
                        <tr>

                            <td>{{ $po->trade_name }}</td>
                            <td>{{ $po->generic_name }}</td>
                            <td>{{ number_format($po->total_price,2) }}</td>
                            <td>{{ $po->quantity }}</td>
                            <td>{{ $po->name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                    <h3 class="text-center text-danger">No Purchase Orders Yet</h3>
                @endif
                @endif
            </div>

            <div class="card-footer">
                {{ $pos->links() }}
            </div>



        </div>
    </section>


@endsection
