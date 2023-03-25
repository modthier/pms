@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Insurance Companies</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Insurance Companies</li>
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
          <a href="{{ route('insuranceCompany.create') }}" class="btn btn-primary">Add Company</a>

        </div>
        <div class="card-body table-responsive p-0">
            
          

            <table class="table table-hover">
                <thead>
                    
                    <th>Name</th>
                    <th>Deduction Rate</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($companies as $company)
                  <tr>
                    
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->deduct_rate }}</td>
                    <td>
                      @if($company->price_value == 0)
                      Unlimited
                      @else 
                      Predetermined
                      @endif
                    </td>
                    <td>
                     
                      <a href="{{ route('insuranceCompany.edit',$company->id) }}" class="btn btn-success float-left mr-1">Edit</a>

                                          
                      
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        <div class="card-footer">
          {{ $companies->links() }}
        </div>



    </div>
</section>

@endsection
