@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              <a href="{{ route('DrugRequests.index') }}">Sales Report</a>
            </h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
<!-- Content Header (Page header) -->

 <section class="col-lg-5">
    <div class="card">
      <div class="card-header">
          <div class="card-title">
              Report Between Two Dates
          </div>
      </div>
      <div class="card-body">  
        <form action="{{ route('salesBetween.DrugRequests') }}" method="get">
              <div class="row">
                  <div class="col-lg-6">
                      <div class="form-group">
                          <label>Date From</label>
                          <input type="date" name="date_from" class="form-control" required>
                      </div>
                  </div>

                   <div class="col-lg-6">
                      <div class="form-group">
                          <label>Date To</label>
                          <input type="date" name="date_to" class="form-control" required>
                      </div>
                  </div>
              </div>

              <div class="form-group">
                  <input type="submit" value="Search" class="btn btn-success">
              </div>
          </form>
       </div>
    </div>
 </section>

  <section class="col-lg-3">
    <div class="card">
      <div class="card-header">
          <div class="card-title">
              Search By Receipt Number
          </div>
      </div>
      <div class="card-body">  
        <form action="{{ route('receiptNumber.DrugRequests') }}" method="get">
              
            <div class="form-group">
                <label>Receipt Number</label>
                <input type="text" name="receipt_number" class="form-control" placeholder="Put the curser here" required>
            </div>
                

            <div class="form-group">
                  <input type="submit" value="Search" class="btn btn-success">
            </div>
          </form>
       </div>
    </div>
 </section>

 <section class="col-lg-4">
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
       <div class="card-header">
            <div class="card-title">
             <h3>Total Sales :   {{ number_format($total,2) }} </h3>
            </div>
        </div>
        
        <div class="card-body table-responsive p-0">

            <table class="table table-hover">
                <thead>
                    <th>Created By</th>
                    <th>Total Price</th>
                    <th>Items Sold</th>
                    <th>Date</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($results as $result)
                  <tr>
                    <td>{{ $result->user->name }}</td>
                    <td>{{ number_format($result->total_price,2) }}</td>
                    <td>{{ $result->total_items }}</td>
                    <td>{{ $result->created_at->format('Y-m-d') }}</td>
                    <td>
                     
                      <a href="{{ route('DrugRequests.show',$result->id) }}" class="btn btn-success float-left mr-1"><span class="fas fa-book-open"></span></a>
                      

                      
                      <a href="{{ route('DrugRequests.edit',$result->id)  }}" class="btn btn-primary float-left mr-1"><span class="fas fa-edit"></span></a>
                     

                      @can('can_show')
                      <form action="{{ route('DrugRequests.destroy',$result->id) }}"
                       method="post" class="float-left mr-1">
                        @csrf

                        {{ method_field('DELETE') }}

                         <button type="submit" class="btn btn-danger" onclick="return confirm('are you sure ?')"><span class="fas fa-trash-alt"></span></button>
                      </form>
                      @endcan


                       <a href="{{ route('ReturnedItems.returnOrder',$result->id)  }}" class="btn btn-warning float-left mr-1"><span class="fas fa-arrow-circle-left"></span></a>
                      

                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        <div class="card-footer">
          {{ $results->links() }}
        </div>



    </div>
</section>

@endsection