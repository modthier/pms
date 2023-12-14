@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Sales Item</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
<!-- Content Header (Page header) -->




   @if(session('errs'))
  <section class="col-lg-12">

    @foreach(session('errs') as $err)
    <div class="alert alert-danger" role="alert">
      {{ $err }}
    </div>
    @endforeach

  </section>
  @endif

  <section class="col-lg-12">
      <div class="card">
          <div class="card-header">
                <div class="header-title">
                    <h4>Item Details</h4>
                </div>
          </div>
          <div class="card-body p-0">
            <table class="table table-hover">
              <thead>
                  <th>{{ __('body.tradeName') }}</th>
                  <th>{{ __('body.unitPrice') }}</th>
                  <th>{{ __('body.discount') }}</th>
                  <th>{{ __('body.quantity') }}</th>
                  <th>{{ __('body.totalPrice') }}</th>
              </thead>

              <tbody>
                
                <tr>
                  <td>{{ $stock->drug->trade_name }}</td>
                  <td>
                      {{ $order->price }}     
                  </td>
                  <td>{{$order->discount}} </td>
                  <td>{{$order->quantity }}</td>
                  <td>
                     {{ number_format($order->quantity *  $order->price,2) }}
                  </td>
                </tr>
               
              </tbody>
          </table>
          </div>
      </div>
  </section>

 <section class="col-lg-12">
    <div class="card">    
    
      <form action="{{ route('drugOrder.updateItem',$order->id) }}" method="post">
        {{ csrf_field() }} 
        {{ method_field('PUT') }}
        <div class="card-body table-responsive p-0">
          <table class="table table-hovered">
              <thead>
                  <th>{{ __('body.tradeName') }}</th>
                  <th>{{ __('body.quantity') }}</th>
                  <th>{{ __('body.price') }}</th>
                  <th>{{ __('body.discount') }}</th>
                  <th>SubTotal</th>
              </thead>

              <tbody class="order_list">
                
                <tr>
                        <td>{{ $stock->drug->trade_name }} - {{ $stock->exp }}</td>
                        <td><input name="items[{{$stock->id}}][quantity]" type="number" class="form-control quantity"  min-value="1" value="{{ $order->quantity }}" 
                          data-id="{{$stock->id}}" data-price="{{$order->price}}" id="qu{{$stock->id}}" data-avl="{{$stock->quantity_per_unit}}">
                        </td>
                        <td>
                          <input type="number" class="form-control order_selling_price" id="price{{$stock->id}}" 
                          data-id="{{$stock->id}}" name="price{{$stock->id}}" value="{{$order->price}}" readonly>
                        </td>
                        <td><input type="number" id="discount_{{$stock->id}}"  class="discount form-control" name="discount{{$stock->id}}" 
                        data-id="{{$stock->id}}" data-price="{{$order->price}}"  min-value="0" value="0" />
                        </td>
                        <td><input type="number" class="form-control sub_total" id="sub_total_{{$stock->id}}" 
                          name="sub_total_$stock->id" value="{{$order->price * $order->quantity}}">
                        </td>
                        <input type="hidden" class="form-control purchasing_price" id="purchasing_price_{{$stock->id}}" 
                          name="purchasing_price_{{$stock->id}}" value="{{$stock->purchasing_price}}">
                        
                    </tr>
              </tbody>
          </table>

         

          
            <h3 style="padding: .75rem 1.25rem;">Total : <span class="total"></span></h3>
            <input type="hidden" id="total_all" name="total">
        </div>
         <div class="card-footer">
          
              <button type="submit" id="orderBtn"  class="btn btn-primary btn-lg">Update</button> 
          
         </div>
      </form>
           

    </div>
</section>


@endsection
