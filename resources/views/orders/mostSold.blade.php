@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Most Sold Items Report</h1>
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
           
            <table class="table table-hover">
                <thead>
                    <th>Trade Name</th>
                    <th>Generic Name</th>
                    <th>Count</th>        
                </thead>

                <tbody>
                  @foreach ($results as $result)
                  <tr>
                    <td>{{ $result->trade_name}}</td>
                    <td>{{ $result->generic_name }}</td>
                    <td>{{ $result->count }}</td>
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