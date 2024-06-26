@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Expired Stock</h1>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



@endsection

@section('content')
    
    <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="card bg-white">
        <div class="card-body">
        <div class="small-box bg-white">
          <div class="inner">
            <h3>{{ $expiredStocks->count() }}</h3>

            <p><strong>Total Items</strong></p>
          </div>
          
        </div>
        </div>
    </div>
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-12">
    <div class="card bg-white">
        <div class="card-body">
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
    </div>
    </div>
   

   <section class="col-lg-12 mt-2">
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
                                    confirm('are you sure ?');"><span class="fas fa-fa-arrow-circle-left"></span></button>
                  
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
