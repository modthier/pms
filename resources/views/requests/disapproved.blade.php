@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Disapproved Request</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('UserRequest.index') }}">Disapproved Request</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')

 <div class="col-lg-4 col-md-4 col-sm-12">
            
        <div class="small-box bg-white">
          <div class="inner">
            <div><strong><a href="{{ route('UserRequest.index') }}">Pendding Requests</a></strong></div>
          </div>
          
        </div>
 </div>

 <div class="col-lg-4 col-md-4 col-sm-12">
            
        <div class="small-box bg-white">
          <div class="inner">
            <div><strong><a href="{{ route('userRequest.approved') }}">Approved Requests</a></strong> <span class="badge badge-success">{{ $approvedCount }}</span></div>
          </div>
          
        </div>
 </div>


 <div class="col-lg-4 col-md-4 col-sm-12">
            
        <div class="small-box bg-white">
          <div class="inner">
            <div><strong><a href="{{ route('userRequest.disapproved') }}">Disapproved Requests</a></strong> <span class="badge badge-danger">{{ $disapprovedCount }}</span></div>
          </div>
          
        </div>
 </div>

<div class="col-lg-12">
  
<div class="card">

    <div class="card-body p-0">
      <table class="table table-hover">
                        <thead>

                        <th>Title</th>
                        <th>Request Type</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Action</th>
                        </thead>

                        <tbody>
                            @foreach($userRequests as $request)
                            <tr>

                                <td>{{ $request->title }}</td>
                                <td>{{ $request->requestType->type }}</td>
                                <td>{{ $request->comment }}</td>
                                <td class="text-danger">
                                  Disapproved
                                </td>
                                <td>
                                  @can('can_access')
                                  <a href="{{ route('UserRequest.approve',$request->id) }}" class="btn btn-success">Approve</a>
                                  @endcan
                                </td>
                                
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
    </div>




              
</div>
</div>

@endsection