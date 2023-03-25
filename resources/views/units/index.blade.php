@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">All Drug Units</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">All Drug Units</li>
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
             <a href="{{ route('drugUnits.create') }}" class="btn btn-primary">Add New</a>
          </div>
          <div class="card-tools">
              {{ $units->links() }}
          </div>
        </div>
        <div class="card-body table-responsive p-0">

            <table class="table table-hover">
                <thead>
                    <th style="width: 10px;">#</th>
                    <th>{{ __('body.unit') }}</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($units as $unit)
                  <tr>
                    <td>{{ $unit->id }}</td>
                    <td>{{ $unit->name }}</td>
                    <td>
                      <a href="{{ route('drugUnits.edit',$unit->id) }}" class="btn btn-success">{{ __('body.edit') }}</a>
                      
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        <!-- <div class="card-footer">

        </div> -->



    </div>
</section>

@endsection
