@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Insurance Company</h1>
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
      <form action="{{ route('insuranceCompany.store') }}" method="post">
        {{ csrf_field() }} 
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="name" 
                        class="form-control" required>
                  </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                    <label>Deduction Rate</label>
                    <input type="number" name="deduct_rate" 
                      class="form-control" required>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                    <label>Price Value</label>
                    <select name="price_value" class="form-control">
                        <option value="1">predetermined</option>
                        <option value="0">unlimited</option>
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
