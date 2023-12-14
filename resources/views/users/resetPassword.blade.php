@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reset Password ({{ $user->name }})</h1>
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
      <form action="{{ route('user.resetPassword',$user->id) }}" method="post">
        {{ csrf_field() }} 
        <div class="card-body">
          <div class="row">
              

               <div class="col-sm-12">
                  <div class="form-group">
                      <label>New Password</label>
                      <input type="password" name="password" 
                        class="form-control" required>
                  </div>
              </div>

               <div class="col-sm-12">
                  <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="password" name="confirm_password" 
                        class="form-control" required>
                  </div>
              </div>


          </div>
        </div>
         <div class="card-footer">
          
              <input type="submit" value="Reset Password" class="btn btn-primary btn-lg">
          
         </div>
      </form>
           

    </div>
</section>

@endsection
