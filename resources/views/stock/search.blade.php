@extends('admin.app')

@section('starter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Available Stock Search Result</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Available Stock Search Result</li>
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
                @if($results)
                @if($results->count() > 0)
                <table class="table table-hover">
                    <thead>

                    <th>Trade Name</th>
                    <th>Generic Name</th>
                    <th>Barcode</th>
                    <th>Purchasing Price</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>EXP</th>
                    <th>Actions</th>
                    </thead>

                    <tbody>
                    @foreach ($results as $result)
                        <tr>

                            <td>{{ $result->trade_name }}</td>
                            <td>{{ $result->generic_name }}</td>
                            <td>{{ $result->barcode }}</td>
                            <td>{{ number_format($result->purchasing_price,2) }}</td>
                            <td>{{ number_format($result->selling_price,2) }}</td>
                            <td>{{ $result->quantity_per_unit }}</td>
                            <td>{{ number_format($result->quantity_per_unit *  $result->purchasing_price,2) }}</td>
                            <td>{{ $result->exp }}</td>
                            <td>
                               <a href="{{ route('stocks.showAddToStockForm',$result->id) }}" class="btn btn-primary btn-sm  mr-1 mb-2">Add To Stock</a>

                                <a href="{{ route('expiredStock.moveToExpiry',$result->id) }}" class="btn btn-warning btn-sm mb-2">Move To Expiry</a>
                                <a href="{{ route('stocks.edit',$result->id) }}" class="btn btn-success float-left btn-sm mr-1">Edit</a>


                                <form class="float-left mr-1" id="delete_stock_{{ $result->id }}"  action="{{ route('stocks.destroy',$result->id) }}"
                                method="post">
                                  @csrf

                                  {{ method_field('DELETE') }}
                                  <button class="btn btn-danger btn-sm" onclick="event.preventDefault();
                                      var r = confirm('are you sure ?');
                                      if (r == true) {document.getElementById('delete_stock_{{ $result->id }}').submit();}">Delete</button>
                  
                                </form>   
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                  <h3  class="text-center text-danger">No Results Found</h3>
                @endif
                @endif

            </div>

            <div class="card-footer">
                {{ $results->withQueryString()->links() }}
            </div>



        </div>
    </section>

@endsection
