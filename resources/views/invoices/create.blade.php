@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Insurance Invoice</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Add Insurance Invoice</li>
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
      <div class="card-header">
        <a href="{{ route('pos.InsuranceSalesReport') }}" class="btn btn-primary">Back</a>
      </div>
      <form action="{{ route('InsuranceInvoice.store') }}" method="post">
        {{ csrf_field() }} 
        <div class="card-body">
          <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                    <label>Insurance Company</label>
                    <select name="insurance_id" class="form-control">
                        @foreach($companies as $company)
                          <option value="{{ $company->id }}" 
                            @if($insurance->first()->id == $company->id)
                            selected 
                            @endif>
                            {{ $company->name }}
                          </option>
                        @endforeach
                    </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                    <label>Date From</label>
                    <input type="text" name="date_from" 
                      class="form-control" value="{{ $date_from }}" required>
                </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                  <label>Date To</label>
                  <input type="text" name="date_to" 
                    class="form-control" value="{{ $date_to }}" required>
              </div>
          </div>

              <div class="col-sm-6">
                  <div class="form-group">
                      <label>Invoice Amount</label>
                      <input type="text" name="amount_duo" 
                        class="form-control" value="{{ $insurance->first()->claim }}" required>
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
