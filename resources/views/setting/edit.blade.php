@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Update Pharmacy Name</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Update Pharmacy Name</li>
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
      <form action="{{ route('setting.update',$setting->id) }}" method="post">
        {{ csrf_field() }} 
        {{ method_field('PUT') }}
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="name" 
                        class="form-control" value="{{ $setting->pharmacy_name }}" required>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Adress</label>
                      <input type="text" name="address" 
                        class="form-control" value="{{ $setting->address }}" required>
                  </div>
              </div>


              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Phone</label>
                      <input type="number" name="tel" 
                        class="form-control" value="{{ $setting->tel }}" required>
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
