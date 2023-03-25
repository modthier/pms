@extends('admin.app')

@section('starter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $user->name }} Purchase Orders</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">User Purchase Orders</li>
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
           
            <div class="card-body table-responsive p-0">
                @if($purchaseOrders)
                @if($purchaseOrders->count() > 0)
                <table class="table table-hover">
                    <thead>

                    <th>Trade Name</th>
                    <th>Generic Name</th>
                    <th>Total Price</th>
                    <th>Quantity</th>  
                    <th>Date</th>  
                    
                    </thead>

                    <tbody>
                    @foreach ($purchaseOrders as $purchaseOrder)
                        <tr>

                            <td>{{ $purchaseOrder->stock->drug->trade_name }}</td>
                            <td>{{ $purchaseOrder->stock->drug->generic_name }}</td>
                            <td>{{  number_format($purchaseOrder->total_price,2)  }}</td>
                            <td>{{ $purchaseOrder->quantity }}</td>  
                            <td>{{ $purchaseOrder->created_at }}</td>  
                            
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
                {{ $purchaseOrders->links() }}
            </div>



        </div>
    </section>

@endsection
