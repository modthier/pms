@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Update Item</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Update Item</li>
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
      <form action="{{ route('item.update',$item->id) }}" method="post">
        {{ csrf_field() }} 
        @method('PUT')
        <div class="card-body">
          <div class="row">
             

              <div class="col-sm-12">
                  <div class="form-group">
                      <label>Item</label>
                      <input type="text" name="item" class="form-control" value="{{ $item->item }}">
                  </div>

                  <div class="form-group">
                    <label>Item Permission</label>
                    <select name="permission" class="form-control" required>
                        <option value=""></option>
                        <option value="Admin" @if($item->permission === 'Admin') selected @endif>Admin</option>
                        <option value="User" @if($item->permission === 'User') selected @endif>User</option>
                    </select>
                </div>
                </div>



          </div>
        </div>
         <div class="card-footer">
          
              <input type="submit" value="Update" class="btn btn-primary btn-lg">
          
         </div>
      </form>
           

    </div>
</section>

@endsection
