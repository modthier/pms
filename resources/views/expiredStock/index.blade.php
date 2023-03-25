@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Expired Stock</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Expired Stock</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



@endsection

@section('content')
    
    <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- small box -->
        <div class="small-box bg-white">
          <div class="inner">
            <h3>{{ $expiredStocks->count() }}</h3>

            <p><strong>Total Items</strong></p>
          </div>
          
        </div>
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- small box -->
        <div class="small-box bg-white">
          <div class="inner">
            <h3>
              @if($total_price)
               {{ $total_price }}
              @endif
            </h3>

            <p><strong>Total Price</strong></p>
          </div>
          
        </div>
    </div>
   

   <section class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                   
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                @if($expiredStocks)
                @if($expiredStocks->count() > 0)
                <table class="table table-hover">
                    <thead>

                    <th>Trade Name</th>
                    <th>Generic Name</th>
                    <th>Expired Quantity</th>
                    <th>Total Price</th>
                    <th>EXP</th>
                    <th>Actions</th>
                    </thead>

                    <tbody>
                    @foreach ($expiredStocks as $expiredStock)
                        <tr>

                            <td>@if($expiredStock->stock){{ $expiredStock->stock->drug->trade_name }}@endif</td>
                            <td>@if($expiredStock->stock){{ $expiredStock->stock->drug->generic_name }}@endif</td>
                            <td>{{ $expiredStock->expired_quantity }}</td>
                            <td>@if($expiredStock->stock)
                                  {{ $expiredStock->stock->purchasing_price *  $expiredStock->expired_quantity}}
                                @endif
                            </td>
                            <td>{{ $expiredStock->stock->exp }}</td>
                            <td>
                                

                                <form  action="{{
                                 route('expiredStock.returnTostock',$expiredStock->id) }}"
                                method="post" class="float-right mr-1">
                                  @csrf

                                  {{ method_field('DELETE') }}
                                  <button class="btn btn-success" onclick="
                                    confirm('are you sure ?');">Move To Stock</button>
                  
                                </form>   
                            </td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                  <h3 class="text-danger text-center">No expired stock yet</h3>
                @endif
                @endif
            </div>

            <div class="card-footer">
                {{ $expiredStocks->links() }}
            </div>



        </div>
    </section>

@endsection
