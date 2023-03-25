@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ $user->name }} Daily Sales Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Daily Sales Report</li>
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
            @if($results)
            @if($results->count() > 0)
            <table class="table table-hover">
                <thead>
                   
                    <th>Total Price</th>
                    <th>Date</th>
                    
                </thead>

                <tbody>
                  @foreach ($results as $result)
                  <tr>
                    <td>{{ number_format($result->total,2) }}</td>
                    <td>{{ $result->created_at }}</td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
            @else
                  <h3  class="text-center text-danger">No Sales Found</h3>
            @endif
            @endif
        </div>

        <div class="card-footer">
          {{ $results->links() }}
        </div>



    </div>
</section>

@endsection