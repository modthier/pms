@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Update Stock</h1>
                </div><!-- /.col -->
               
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')

<section class="col-lg-12">
        @if($results)
        @if($results->count() > 0)
        <div class="card">
            <form action="{{ route('stocks.updatePrice') }}" method="post">
              <input type="hidden" name="unit_id" value="{{ $unit_id }}">
              <input type="hidden" name="item_type_id" value="{{ $item_type_id }}">
                {{ csrf_field() }} 
            <div class="card-header">
                <div class="form-group">
                    <label>Profit Margin (%)</label>
                    <select name="pst" id="profit_margin" class="form-control">
                       
                          <option value="0">0%</option>
                          <option value="10">10%</option>
                          <option value="20">20%</option>
                          <option value="30">30%</option>
                          <option value="40">40%</option>
                          <option value="50">50%</option>
                          <option value="60">60%</option>
                          <option value="70">70%</option>
                          <option value="80">80%</option>
                          <option value="90">90%</option>
                          <option value="100">100%</option>
                      </select>
                </div>
               
            </div>
            <div class="card-body table-responsive p-0">
               
                
                
                <table class="table table-hover">
                    <thead>
                    <th><input id="selectAll" type="checkbox"></th>
                    <th>Trade Name</th>
                    <th>Drug Type</th>
                    <th>Unit</th>
                    <th>Purchasing Price</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>PST</th>
                    <th>EXP</th>
                    </thead>

                    <tbody>
                    
                        
                  
                    @foreach ($results as $result)
                       
                        <tr>
                            <td><input name="stock_id[]" value="{{ $result->id }}" type="checkbox" ></td>
                            <td>{{ $result->trade_name }}</td>
                            <td>{{ $result->type }}</td>
                            <td>{{ $result->name }}</td>
                            <td>
                              <div class="form-group">
                               <input type="text" name="purchasing_price_{{ $result->id }}" value="{{ $result->purchasing_price }}" required="" class="form-control">
                              </div>
                              <input type="hidden" name="count_{{ $result->id }}" value="{{ $result->count_per_unit }}">

                              <input type="hidden" name="quantity_{{ $result->id }}" value="{{ $result->quantity }}">
                            </td>
                            <td>{{ number_format($result->selling_price,2) }}</td>
                            <td>{{ $result->quantity_per_unit }}</td>
                            <td>{{ $result->pst }}</td>
                            <td>{{ $result->exp }}</td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                
               
               
           </div>

            <div class="card-footer">
                <div class="form-group">
                     <input type="submit" value="Update Price" class="btn btn-success">
                 </div>
            </div>


            </form>
        </div>
       
        @else

        <h3 class="text-danger">No Results Found</h3>
        @endif
        @endif
    </section>

    <script type="text/javascript" src="{{ asset('js/select.js') }}" defer></script>

@endsection