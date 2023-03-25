@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('body.allDrugs') }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">{{ __('body.allDrugs') }}</li>
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
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-12">
                        <form  action="{{ route('drugs.search') }}" method="get">

                      <div class="input-group">
                        <input class="form-control" id="input2-group2" type="search" name="q"  placeholder="{{ __('body.search') }}">
                        <span class="input-group-append">
                          <button class="btn btn-primary" type="submit">{{ __('body.search') }}</button>
                        </span>
                      </div>

                       </form>
                    </div>
                   </div>
                </div>
        </div>
</section>

 <section class="col-lg-12">
    <div class="card">
        <div class="card-header">
          <div class="card-title">
            @can('can_show')
             <a href="{{ route('drugs.create') }}" class="btn btn-primary">{{ __('body.addNew') }}</a>
             <a href="{{ route('DrugWithStock.create') }}" class="btn btn-primary">Add Drug With Stock</a>
             <a href="{{ route('drug.export') }}" class="btn btn-success">Export To Excel</a>
             @endcan
          </div>
        </div>
        <div class="card-body table-responsive p-0">
            {{ $drugs->links() }}
          

            <table class="table table-hover">
                <thead>
                    
                    <th>{{ __('body.tradeName') }}</th>
                    <th>{{ __('body.genericName') }}</th>
                    <th>Type</th>
                    <th>{{ __('body.unit') }}</th>
                    
                    <th>{{ __('body.hasStock') }}</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($drugs as $drug)
                  <tr>
                    
                    <td>{{ $drug->trade_name }}</td>
                    <td>{{ $drug->generic_name }}</td>
                    <td>{{ $drug->drugItemType->type }}</td>
                    <td>{{ $drug->drugUnit->name }}</td>
                    
                    @if($drug->stocks()->count() > 0)
                      <td>{{ __('body.yes') }}</td>
                    @else 
                      <td>{{ __('body.no') }}</td>
                    @endif
                    <td>
                      @can('can_show')
                      <a href="{{ route('drugs.edit',$drug->id) }}" class="btn btn-success float-left mr-1">{{ __('body.edit') }}</a>
                      @endcan

                      @can('can_show')
                        @if($drug->stocks()->count() == 0)
                          
                         

                            <form  action="{{ route('drugs.destroy',$drug->id) }}"
                                method="post" id="delete_drug_{{ $drug->id }}" class="float-left mr-1 mr-1">
                                  @csrf

                                  {{ method_field('DELETE') }}
                                  <button class="btn btn-danger" onclick="event.preventDefault();
                                      var r = confirm('are you sure ?');
                                      if (r == true) {document.getElementById('delete_drug_{{ $drug->id }}').submit();}">{{ __('body.delete') }}</button>
                  
                            </form>   
                        
                        @endif
                      @endcan
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        <div class="card-footer">
          {{ $drugs->links() }}
        </div>



    </div>
</section>

@endsection
