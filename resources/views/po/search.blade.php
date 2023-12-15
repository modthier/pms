@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Purchase Orders Search Result</h1>
                </div><!-- /.col -->
               
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
    <!-- Content Header (Page header) -->

    <section class="col-lg-12 mt-2 ">
        <div class="card">
           
            <div class="card-body table-responsive p-0">
                @if($results)
                @if($results->count() > 0)
                <table class="table table-hover">
                    <thead>

                    <th>Trade Name</th>
                    <th>Generic Name</th>
                    <th>Total Price</th>
                    <th>Quantity</th>
                    <th>Created By</th>
                    
                    </thead>

                    <tbody>
                    @foreach ($results as $result)
                        <tr>

                            <td>{{ $result->trade_name }}</td>
                            <td>{{ $result->generic_name }}</td>
                            <td>{{ number_format($result->total_price,2) }}</td>
                            <td>{{ $result->quantity }}</td>
                            <td>{{ $result->name }}</td>
                            
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

@endsection
