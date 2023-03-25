@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Drugs Search Result</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('drugs.index') }}">Drugs</a></li>
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
       
        <div class="card-body table-responsive p-0">

            <table class="table table-hover">
                <thead>
                    
                    <th>Trade Name</th>
                    <th>Generic Name</th>
                    <th>Type</th>
                    <th>Unit</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($results as $result)
                  <tr>
                  
                    <td>{{ $result->trade_name }}</td>
                    <td>{{ $result->generic_name }}</td>
                    <td>{{ $result->drugItemType->type }}</td>
                    <td>{{ $result->drugUnit->name }}</td>
                    <td>
                      @can('can_show')
                      <a href="{{ route('drugs.edit',$result->id) }}" class="btn btn-success float-left mr-1">Edit</a>

                      
                       <form  action="{{ route('drugs.destroy',$result->id) }}"
                                method="post" id="delete_drug_{{ $result->id }}" class="float-left mr-1">
                                  @csrf

                                  {{ method_field('DELETE') }}
                                  <button class="btn btn-danger" onclick="event.preventDefault();
                                      var r = confirm('are you sure ?');
                                      if (r == true) {document.getElementById('delete_drug_{{ $result->id }}').submit();}">Delete</button>
                  
                      </form>  
                       @endcan 
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        <div class="card-footer">
          {{ $results->withQueryString()->links() }}
        </div>



    </div>
</section>

@endsection
