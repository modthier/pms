@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Item</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Add Item</li>
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
      <form action="{{ route('item.store') }}" method="post">
        {{ csrf_field() }} 
        <div class="card-body">
          <div class="row">
             

              <div class="col-sm-12">
                  <div class="form-group">
                      <label>Item</label>
                      <input type="text" name="item" class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Item Permission</label>
                    <select name="permission" class="form-control" required>
                        <option value=""></option>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>
                </div>
                </div>



          </div>
        </div>
         <div class="card-footer">
          
              <input type="submit" value="Save" class="btn btn-primary btn-lg">
          
         </div>
      </form>
           

    </div>
</section>

@endsection
