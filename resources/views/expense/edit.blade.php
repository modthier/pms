@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Update Expense</h1>
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
      <form action="{{ route('expense.update',$expense->id) }}" method="post">
        {{ csrf_field() }} 
        @method('PUT')
        <div class="card-body">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Expense Item</label>
                      <select name="item_id" class="form-control" required>
                        <option></option>
                        @foreach($items as $item)
                        <option value="{{ $item->id }}" 
                            @if($expense->item_id == $item->id) selected @endif >{{ $item->item }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Expense Value</label>
                      <input type="number" name="value" class="form-control" value="{{ $expense->value }}">
                  </div>
              </div>

              <div class="col-sm-12">
                  <div class="form-group">
                      <label>Comment</label>
                      <textarea name="comment" class="form-control" rows="5">{{ $expense->comment }}</textarea>
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
