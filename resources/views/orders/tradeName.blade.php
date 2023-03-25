@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Search By Trade Name</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Search By Trade Name</li>
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
      <div class="card-header">
          <div class="card-title">
              Search By Trade Name
          </div>
      </div>
      <div class="card-body">  
        <form action="{{ route('tradeName.DrugRequests') }}" method="get">
              
            <div class="form-group">
                <label>Trade Name</label>
                <input type="text" name="trade_name" class="form-control" required>
            </div>
                

            <div class="form-group">
                  <input type="submit" value="Search" class="btn btn-success">
            </div>
          </form>
       </div>
    </div>
 </section>



  

 <section class="col-lg-12">
    <div class="card">
        
        <div class="card-body table-responsive p-0">
            @if($results)
            @if($results->count() > 0)
            <table class="table table-hover">
                <thead>
                    <th>{{ __('body.createdBy') }}</th>
                    <th>{{ __('body.tradeName') }}</th>
                    <th>{{ __('body.totalPrice') }}</th>
                    <th>{{ __('body.discount') }}</th>
                    <th>Date</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($results as $result)
                  <tr>
                    <td>{{ $result->name }}</td>
                    <td>{{ $result->trade_name }}</td>
                    <td>{{ number_format($result->total_price,2) }}</td>
                    <td>{{$result->discount}}</td>
                    <td>{{ $result->created_at }}</td>
                    <td>
                     
                      <a href="{{ route('DrugRequests.show',$result->id) }}" class="btn btn-success float-left mr-1">{{ __('body.details') }}</a>
                      

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
  <script type="text/javascript">
    JsBarcode(".barcode").init();
  </script>
@endsection