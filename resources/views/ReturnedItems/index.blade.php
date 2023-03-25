@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Purchase returns</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Purchase returns</li>
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
            @if($returns)
            @if($returns->count() > 0)
            <table class="table table-hover">
                <thead>
                    <th>Trade Name</th>
                    <th>Quantity Returned</th>
                    <th>Total Price</th>
                </thead>

                <tbody>
                  @foreach ($returns as $return)
                  <tr>
                    <td>@if($return->stock){{ $return->stock->drug->trade_name }}@endif</td>
                    <td>{{ $return->quantity_returned }}</td>
                    <td>@if($return->stock){{ $return->stock->selling_price * $return->quantity_returned }}@endif</td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
            @else
              <h3 class="text-danger text-center">No Purchase returns</h3>
            @endif
            @endif

        </div>

        <div class="card-footer">
          {{ $returns->links() }}
        </div>



    </div>
</section>

@endsection