@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add New Request</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('UserRequest.index') }}">Add New Request</a></li>
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
      <form action="{{ route('UserRequest.store') }}" method="post">
        {{ csrf_field() }} 
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Title</label>
                      <input type="text" name="title" 
                        class="form-control" required>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Request Type</label>
                      <select name="type" class="form-control"  required>
                          <option></option>
                          @foreach($types as $type)
                          <option value="{{ $type->id }}">{{ $type->type }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-sm-12">
                  <div class="form-group">
                      <label>Comment</label>
                      <textarea class="form-control" rows="3" name="comment" required></textarea>
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
