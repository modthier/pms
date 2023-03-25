@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Expense</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Add Expense</li>
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
      <form action="{{ route('expense.store') }}" method="post">
        {{ csrf_field() }} 
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Expense Item</label>
                      <select name="item_id" class="form-control" required>
                        <option></option>
                        @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->item }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Expense Value</label>
                      <input type="number" name="value" class="form-control">
                  </div>
              </div>

              <div class="col-sm-12">
                  <div class="form-group">
                      <label>Comment</label>
                      <textarea name="comment" class="form-control" rows="5"></textarea>
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
