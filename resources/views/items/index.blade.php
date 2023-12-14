@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Expenses</h1>
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
          <a href="{{ route('expense.create') }}" class="btn btn-primary">Add Expense Item</a>

        </div>
        <div class="card-body table-responsive p-0">
            
          

            <table class="table table-hover">
                <thead>
                    
                    <th>Item</th>
                    <th>Permission</th>
                    <th>Action</th>
                </thead>

                <tbody>
                  @foreach ($items as $item)
                  <tr>
                    
                    <td>{{ $item->item }}</td>
                    <td>{{ $item->permission }}</td>
                    <td>
                      <a href="{{ route('item.edit',$item->id) }}" class="btn btn-success float-left mr-1"><span class="fas fa-edit"></span></a>          
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        <div class="card-footer">
         
        </div>



    </div>
</section>

@endsection
