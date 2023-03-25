@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">All Bank Accounts</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">All Bank Accounts</li>
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
             <a href="{{ route('accounts.create') }}" class="btn btn-primary">Add New</a>
          </div>
          <div class="card-tools">
              {{ $accounts->links() }}
          </div>
        </div>
        <div class="card-body table-responsive p-0">

            <table class="table table-hover">
                <thead>
                    <th style="width: 10px;">#</th>
                    <th>Account</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($accounts as $account)
                  <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->name }}</td>
                    <td>
                       
                      <a href="{{ route('accounts.edit',$account->id) }}" class="btn btn-success">Edit</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        <div class="card-footer">
             {{ $accounts->links() }}
        </div>



    </div>
</section>

@endsection
