@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Due to be expired items</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



@endsection

@section('content')

   

   <section class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h2>Total : ({{ $homeStocks->count() }})</h2> 
                </div>
            </div>
            <div class="card-body table-responsive p-0">

                <table class="table table-hover">
                    <thead>

                    <th>Trade Name</th>
                    <th>Generic Name</th>
                    <th>Barcode</th>
                    <th>Purchasing Price</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>EXP</th>
                    <th>Remainning Month</th>
                    </thead>

                    <tbody>
                    @foreach ($homeStocks as $stock)
                        <tr>

                            <td>{{ $stock->trade_name }}</td>
                            <td>{{ $stock->generic_name }}</td>
                            <td>{{ $stock->barcode }}</td>
                            <td>{{ $stock->purchasing_price }}</td>
                            <td>{{ $stock->selling_price }}</td>
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

@endsection
