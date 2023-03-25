@extends('admin.app')

@section('starter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('body.availableStock') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">{{ __('body.availableStock') }}</li>
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
                        <form  action="{{ route('stocks.search') }}" method="get">

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


<section class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <form  action="{{ route('stocks.check') }}" method="get">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                         <label>Choose Stock</label>
                            <select name="drug_id" class="form-control" style="width: 100%;"  id="avlDrugId">
                                 <option></option>
                             </select>
                          </div>
                       </div>
                     <div class="col-sm-4">
                      <div class="form-group">
                          <label>Drug Type</label>
                          <select class="form-control"  name="item_type_id" required>
                            <option></option>
                            @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                            @endforeach
                          </select>
                      </div>
                     </div>

                     <div class="col-sm-4">
                      <div class="form-group">
                          <label>Drug Unit</label>
                          <select class="form-control"  name="unit_id" required>
                            <option></option>
                            @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" value="Check" class="btn btn-success">
                </div>
           </form>
         </div>
       </div>
               
      
</section>
    
<div class="col-lg-12 col-md-12 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-white box-shadow">
                  <div class="inner">
                    <h3>
                      @if($total_price->total_price)
                       {{ number_format($total_price->total_price,2) }}
                      @endif
                    </h3>

                    <p><strong> {{ __('body.wholePrice') }} </strong></p>
                  </div>
                  
                </div>
           </div>
    <section class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                     
                </div>
                <div class="card-title">
                    <a href="{{ route('stocks.create') }}" class="btn btn-primary">{{ __('body.addNew') }}</a>
                    @if($stocks)
                    @if($stocks->count() > 0)
                    <a href="{{ route('stock.export') }}" class="btn btn-primary">{{ __('body.exportToExcel') }}</a>
                    @endif
                    @endif
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                @if($stocks)
                @if($stocks->count() > 0)
                <table class="table table-hover">
                    <thead>

                    <th>{{ __('body.tradeName') }}</th>
                    <th>Purchase Bonus</th>
                    <th>{{ __('body.purchasingPrice') }}</th>
                    <th>{{ __('body.sellingPrice') }}</th>
                    <th>{{ __('body.quantity') }}</th>
                    <th>{{ __('body.totalPrice') }}</th>
                    <th>{{ __('body.exp') }}</th>
                    <th>Actions</th>
                    </thead>

                    <tbody>
                    @foreach ($stocks as $stock)
                       
                        <tr>
                        
                            <td 
                               @if($stock->rem <= 3) class="bg-danger"
                               @elseif ($stock->rem <= 6 and $stock->rem > 3) class="bg-warning"
                                @elseif ($stock->rem > 6) class="bg-success"
                               @endif
                                >{{ $stock->trade_name }}</td>
                            
                            <td>{{ number_format($stock->bonus,2)  }} ({{ $stock->bonus_pst }}%)</td>
                            <td>{{ number_format($stock->purchasing_price,2) }}</td>
                            <td>{{ number_format($stock->selling_price,2) }}</td>
                            <td>{{ $stock->quantity_per_unit }}</td>
                            <td>{{ number_format($stock->quantity_per_unit *  $stock->selling_price,2) }}</td>
                            <td>{{ $stock->exp }}</td>
                            <td>
                                <a href="{{ route('stocks.showAddToStockForm',$stock->id) }}" class="btn btn-primary btn-sm  mr-1 mb-2">{{ __('body.addToStock') }}</a>

                                <a href="{{ route('expiredStock.moveToExpiry',$stock->id) }}" class="btn btn-warning btn-sm mb-2">{{ __('body.moveToExpiry') }}</a>
                                <a href="{{ route('stocks.edit',$stock->id) }}" class="btn btn-success float-left btn-sm mr-1">{{ __('body.edit') }}</a>


                                <form class="float-left mr-1" id="delete_stock_{{ $stock->id }}"  action="{{ route('stocks.destroy',$stock->id) }}"
                                method="post">
                                  @csrf

                                  {{ method_field('DELETE') }}
                                  <button class="btn btn-danger btn-sm" onclick="event.preventDefault();
                                      var r = confirm('are you sure ?');
                                      if (r == true) {document.getElementById('delete_stock_{{ $stock->id }}').submit();}">{{ __('body.delete') }}</button>
                  
                                </form>   
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else 
                    <h3 class="text-center text-danger">No Products in the stock yet</h3>
                @endif
                @endif
            </div>

            <div class="card-footer">
                {{ $stocks->links() }}
            </div>



        </div>
    </section>

@endsection


 