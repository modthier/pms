@extends('admin.app')

@section('starter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">All Shifts</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">All Shifts</li>
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
             <a href="{{ route('Shifts.create') }}" class="btn btn-primary">Add New</a>
          </div>
        </div>
            <div class="card-body table-responsive p-0">

                <table class="table table-hover">
                    <thead>

                    <th>Shift</th>
                    <th>Begin</th>
                    <th>End</th>
                    <th>Actions</th>
                    </thead>

                    <tbody>
                    @foreach ($shifts as $shift)
                        <tr>

                            <td>{{ $shift->shift }}</td>
                            <td>{{ $shift->begin }}</td>
                            <td>{{ $shift->end }}</td>
                            <td>
                                <a href="{{ route('Shifts.edit',$shift->id) }}" class="btn btn-success">Edit</a>
                               
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <div class="card-footer">
               
            </div>



        </div>
    </section>

@endsection
