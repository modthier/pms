@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('body.stockHistory') }}</h1>
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
           
            <div class="card-body table-responsive p-0">

                <table class="table table-hover">
                    <thead>

                    <th>{{ __('body.tradeName') }}</th>
                    <th>{{ __('body.genericName') }}</th>
                    <th>{{ __('body.purchasingPrice') }}</th>
                    <th>{{ __('body.sellingPrice') }}</th>
                    <th>{{ __('body.quantity') }}</th>
                    <th>{{ __('body.exp') }}</th>
                    <th>Date Added</th>
                   
                    </thead>

                    <tbody>
                    @foreach ($stocks as $stock)
                        <tr>

                            <td>{{ $stock->trade_name }}</td>
                            <td>{{ $stock->generic_name }}</td>
                            <td>{{ number_format($stock->purchasing_price,2) }}</td>
                            <td>{{ number_format($stock->selling_price,2) }}</td>
                            <td>{{ $stock->quantity_per_unit }}</td>
                            <td>{{ $stock->exp }}</td>
                            <td>{{ $stock->created_at }}</td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <div class="card-footer">
                {{ $stocks->links() }}
            </div>



        </div>
    </section>

@endsection
