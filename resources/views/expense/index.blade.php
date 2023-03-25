@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Expenses</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Expenses</li>
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
          {{ number_format($total_today,2) }}
          
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
          {{ number_format($total_week,2) }}
          
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
          {{ number_format($total_month,2) }}
          
          @endif
        </h3>

        <p><strong>Total Month</strong></p>
      </div>

     </div>
</div>


 <section class="col-lg-12">
    <div class="card">
        <div class="card-header">
          <a href="{{ route('expense.create') }}" class="btn btn-primary">Add Expense</a>

        </div>
        <div class="card-body table-responsive p-0">
            
          

            <table class="table table-hover">
                <thead>
                    
                    <th>Item</th>
                    <th>Value</th>
                    <th>Comment</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                  @foreach ($expenses as $expense)
                  <tr>
                    
                    <td>{{ $expense->item->item }}</td>
                    <td>{{ number_format($expense->value,2) }}</td>
                    <td>{{ $expense->comment }}</td>
                    <td>
                      <a href="{{ route('expense.edit',$expense->id) }}" class="btn btn-success float-left mr-1">Edit</a>          
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

        </div>

        <div class="card-footer">
          {{ $expenses->links() }}
        </div>



    </div>
</section>

@endsection
