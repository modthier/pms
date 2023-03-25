@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ $user->name }} Sales Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Sales Report</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
<!-- Content Header (Page header) -->

<div class="col-lg-4 col-md-4 col-sm-12">
            <!-- small box -->
        <div class="small-box bg-white">
          <div class="inner">
            <h3>
              @if($total_today)
              @money($total_today,'SDG')
              @else
              @money(0,'SDG')
              @endif
            </h3>

            <p><strong>Total Today</strong></p>
          </div>
          
        </div>
 </div>


<div class="col-lg-4 col-md-4 col-sm-12">
            <!-- small box -->
        <div class="small-box bg-white">
          <div class="inner">
            <h3>
              @if($total_week)
              @money($total_week,'SDG')
              @else
              @money(0,'SDG')
              @endif
            </h3>
           

            <p><strong>Total Week</strong></p>
          </div>
          
        </div>
 </div>

 <div class="col-lg-4 col-md-4 col-sm-12">
            <!-- small box -->
        <div class="small-box bg-white">
          <div class="inner">
            <h3>
              @if($total_month)
              @money($total_month,'SDG')
              @else
              @money(0,'SDG')
              @endif
            </h3>
            

            <p><strong>Total Month</strong></p>
          </div>
          
        </div>
 </div>

   



 <section class="col-lg-12">
    <div class="card">
        <div class="card-body table-responsive p-0">
            @if($orderRequests)
            @if($orderRequests->count() > 0)
            <table class="table table-hover">
                <thead>
                    <th>Created By</th>
                    <th>Total Price</th>
                    <th>Items Sold</th>
                    <th>Date</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($orderRequests as $orderRequest)
                  <tr>
                    <td>{{ $orderRequest->user->name }}</td>
                    <td>@money($orderRequest->total_price,'SDG')</td>
                    <td>{{ $orderRequest->total_items }}</td>
                    <td>{{ $orderRequest->created_at }}</td>
                    <td>
                     
                      <a href="{{ route('DrugRequests.show',$orderRequest->id) }}" class="btn btn-success float-left mr-1">Details</a>
                      

                      
                      
                    
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
            @else 
              <h3 class="text-center text-danger">No Sales Yet</h3>
            @endif
            @endif
        </div>

        <div class="card-footer">
          {{ $orderRequests->links() }}
        </div>



    </div>
</section>

@endsection