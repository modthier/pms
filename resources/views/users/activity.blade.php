@extends('admin.app')

@section('starter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $user->name }} Activities</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">User Activities</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
    <!-- Content Header (Page header) -->



    <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $salesOrders }}</h3>

            <p>Sales Orders</p>
          </div>
          <a href="{{ route('user.DrugRequests',$user->id) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>


    <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner" style="padding-bottom: 3.1rem;">
            

            <h3 class="text-center">Day By Day Sales Orders</h3>
          </div>
          <a href="{{ route('user.dailyTotal',$user->id) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>


    <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $purchaseOrders }}</h3>

            <p>purchase Orders</p>
          </div>
          <a href="{{ route('user.po',$user->id) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>


    <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $shifts }}</h3>

                <p>Shifts</p>
              </div>
              <a href="{{ route('user.shift',$user->id) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

@endsection
