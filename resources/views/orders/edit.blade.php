@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Sales Order</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
<!-- Content Header (Page header) -->

<section class="col-lg-6 col-md-6 col-sm-12">
  <div class="card">    
      <div class="card-header">
          <div class="card-title">
            {{ __('body.scanner') }}
          </div>
      </div>

      <div class="card-body" style="padding-bottom: 4.6em;">
          
            {{ csrf_field() }} 
            <div class="form-group">
              <input type="number" name="scanner" id="scanner" class="form-control">
            </div>

           
    </div>
    </div>
 </section>

<section class="col-lg-6 col-md-6 col-sm-12">
  <div class="card">    
      <div class="card-header">
          <div class="card-title">
            {{ __('body.itemSelect') }}
          </div>
      </div>

      <div class="card-body">
          <form>
            {{ csrf_field() }} 
           
             <div class="form-group">
               <select class="form-control" style="width: 100%;" id="stockId">
                  
                    <option></option>
                    
                  
                </select>
             </div>
               
             <div class="form-group">
              <button  id="addItemByName" type="button" class="btn btn-info">{{ __('body.addItem') }}</button>
             </div>
            
          </form>  
    </div>
    </div>
 </section>

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
    
      <form action="{{ route('DrugRequests.update',$orders->id) }}" method="post">
        {{ csrf_field() }} 
        {{ method_field('PUT') }}
        <div class="row p-3">
              

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>{{ __('body.paymentMethod') }}</label>
                      <select name="method_id" class="form-control select2" style="width: 100%;" required>
                          <option></option>
                          @foreach ($payments as $payment)
                              <option value="{{ $payment->id }}" 
                                @if($orders->paymentMethod_id == $payment->id) selected 
                                @endif
                                >{{ $payment->method }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hovered">
              <thead>
                  <th>{{ __('body.tradeName') }}</th>
                  <th>{{ __('body.quantity') }}</th>
                  <th>{{ __('body.price') }}</th>
                  <th>{{ __('body.discount') }}</th>
                  <th>Actions</th>
              </thead>

              <tbody class="order_list">
                @foreach ($orders->stock as $one)
                  <tr>
                    <td>{{ $one->drug->trade_name }}</td>
                    <td><input name="items[{{ $one->id }}][quantity]" type="number" class="form-control quantity"
                       min-value="1" value="{{ $one->pivot->quantity }}" data-id="{{ $one->id }}" 
                       data-price="{{ $one->selling_price }}" id="qu{{ $one->id }}" 
                       data-avl="{{$one->quantity_per_unit}}">
                    </td>
                    <td>
                      <input type="number" class="form-control order_selling_price" id="price{{ $one->id }}" 
                      data-id="{{$one->id}}" name="price{{$one->id}}" value="{{ ($one->pivot->price + $one->pivot->discount) / $one->pivot->quantity }}" readonly>
                    </td>
                    <td><input type="number" id="discount_{{$one->id}}"  class="discount form-control" name="discount{{$one->id}}" 
                    data-id="{{ $one->id }}" data-price="{{ ($one->pivot->price + $one->pivot->discount) / $one->pivot->quantity }}"  min-value="0" value="{{ $one->pivot->discount }}" />
                    </td>
                    <td><input type="number" class="form-control sub_total" id="sub_total_{{$one->id}}" 
                      name="sub_total_{{ $one->id }}" value="{{ $one->pivot->price }}">
                    </td>
                    <td><button data-stock-id="{{ $one->id }}" class="btn btn-danger delete-item"><span class="fas fa-trash-alt"></span></button>
                    </td>
                    <input type="hidden" class="form-control purchasing_price" id="purchasing_price_{{ $one->id }}" 
                      name="purchasing_price_{{ $one->id }}" value="{{ $one->pivot->purchasing_price }}">
                    
                </tr>
                @endforeach
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
