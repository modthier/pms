@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">All Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">All Users</li>
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
             <a href="{{ route('register.create') }}" class="btn btn-primary">Add New</a>
          </div>
         
        </div>
        <div class="card-body table-responsive p-0">

            <table class="table table-hover">
                <thead>
                    <th style="width: 10px;">#</th>
                    <th>Name</th>
                    <th>Eamil</th>
                    <th>Role</th>
                    <th>Shift</th>
                    <th>Status</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($users as $user)
                  <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>
                        @if($user->shift_id != null)
                        {{ $user->userShift->shift }}
                        @endif 
                    </td>
                    
                      @if($user->active == 1)
                        <td>Active</td>

                      @else 
                        <td>Disabled</td>
                      @endif
                    
                    <td>

                      <a href="{{ route('register.edit',$user->id) }}" class="btn btn-success btn-sm float-left ml-1">Update</a>
                      @if($user->active == 1)
                        <a href="{{ route('user.disableUser',$user->id) }}" class="btn btn-warning btn-sm float-left ml-1">Disable Login</a>
                      @else 
                        <a href="{{ route('user.enableUser',$user->id) }}" class="btn btn-primary btn-sm float-left mr-1">Enable Login</a>
                      @endif
                      <a href="{{ route('user.activity',$user->id) }}" class="btn btn-success btn-sm float-left ml-1 mr-1">Show Activity</a>

                       <a href="{{ route('user.resetPasswordForm',$user->id) }}" class="btn btn-sm btn-primary float-left  mr-1">
                        Reset Password
                      </a>
                      
                     


                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        



    </div>
</section>

@endsection
