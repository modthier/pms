@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create Invoices</h1>
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
                <a href="{{ route('pos.InsuranceSalesReport') }}" class="btn btn-primary">Back</a>
          </div>
          <div class="card-body p-0">
               <h3 class="text-center text-danger"> No A Mount Duo Found between the dates you specified</h3>
          </div>
      
  </div>
</section>




@endsection
