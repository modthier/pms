@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Setting</h1>
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
        @if($setting->count() > 0)
        <div class="card-body table-responsive p-0">

            <table class="table table-hover">
                <thead>
                   
                    <th>{{ __('body.pharmacyName') }}</th>
                    <th>{{ __('body.address') }}</th>
                    <th>{{ __('body.tel') }}</th>
                  
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($setting as $name)
                  <tr>
                    <td>{{ $name->pharmacy_name }}</td>
                    <td>{{ $name->address }}</td>
                    <td>{{ $name->tel }}</td>
                
                    <td>
                       
                      <a href="{{ route('setting.edit',$name->id) }}" class="btn btn-success"><span class="fas fa-edit"></span></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        @else
        <h3 class="text-center text-danger">Pharmacy name has not been set yet</h3>
        <a href="{{ route('setting.create') }}" class="btn btn-primary">Set Pharmacy Name</a>
        @endif

        



    </div>
</section>

@endsection
