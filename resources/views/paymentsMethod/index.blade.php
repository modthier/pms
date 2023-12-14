@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">All Payment Methods</h1>
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
          <div class="card-title">
          <a href="{{ route('paymentMethod.create') }}" class="btn btn-primary">Add New</a>
          </div>
        </div>
        <div class="card-body table-responsive p-0">

          

            <table class="table table-hover">
                <thead>
                    
                    <th>Payment Method</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($payments as $payment)
                  <tr>
                    <td>{{ $payment->method }}</td>
                    <td>
                     
                      <a href="{{ route('paymentMethod.edit',$payment->id) }}" class="btn btn-success"><span class="fas fa-edit"></span></a>
                     
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
