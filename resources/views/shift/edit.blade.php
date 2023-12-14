@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Shift</h1>
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
      <form action="{{ route('Shifts.update',$shift->id) }}" method="post">
        {{ csrf_field() }} 

        {{ method_field('PUT') }}
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Shift</label>
                      <input type="text" name="shift" 
                        class="form-control" value="{{ $shift->shift }}"  required>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Begin</label>
                      <input type="time" name="begin" 
                        class="form-control" value="{{ $shift->begin }}" required>
                  </div>
              </div>

             <div class="col-sm-6">
                  <div class="form-group">
                      <label>End</label>
                      <input type="time" name="end" 
                        class="form-control" value="{{ $shift->end }}" required>
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
