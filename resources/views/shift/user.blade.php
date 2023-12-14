@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $user->name }} Shifts</h1>
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

                    <th>Shift</th>
                    <th>Date</th>
                    <th>Logged Out Time</th>
                    
                    </thead>

                    <tbody>
                    @foreach ($shifts as $shift)
                        <tr>

                            <td>{{ $shift->shift }}</td>
                            <td>{{ $shift->created_at }}</td>
                            <td>{{ $shift->loggedout_at }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <div class="card-footer">
               {{ $shifts->links() }}
            </div>



        </div>
    </section>

@endsection
