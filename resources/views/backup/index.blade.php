@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Backup</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
<!-- Content Header (Page header) -->




        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <form action="{{ url('backup/create') }}" method="GET" class="add-new-backup" enctype="multipart/form-data" id="CreateBackupForm">
                {{ csrf_field() }}
                <input type="submit" name="submit" class="theme-button btn btn-primary pull-right" style="margin-bottom:2em;" value="Create Database Backup">
              </form>
            </div>
            <div class="card-body table-responsive p-0">
                 

                  @if ( Session::has('update') )
                  <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      {{ Session::get('update') }}
                  </div>
                  @endif

                  @if ( Session::has('delete') )
                  <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      {{ Session::get('delete') }}
                  </div>
                  @endif

              @if (count($backups))
                  <table class="table table-striped">
                      <thead>
                      <tr>
                          <th>File Name</th>
                          <th>File Size</th>
                          <th>Created Date</th>
                          <th>Created Age</th>
                          <th>Actions</th>
                          
                      </tr>
                      </thead>
                      <tbody>
                      @foreach($backups as $backup)
                          <tr>
                              <td>{{ $backup['file_name'] }}</td>
                              <td>{{ \App\Http\Controllers\BackupController::humanFilesize($backup['file_size']) }}</td>
                              <td>
                                  {{ date('F jS, Y, g:ia (T)',$backup['last_modified']) }}
                              </td>
                              <td>
                                  {{ \Carbon\Carbon::parse($backup['last_modified'])->diffForHumans() }}
                              </td>
                              <!--<td class="text-right">
                                <a class="btn btn-success"
                                   href="{{ url('backup/download/'.$backup['file_name']) }}"><i
                                        class="fa fa-cloud-download"></i> Download</a>
                                <a class="btn btn-danger" onclick="return confirm('Do you really want to delete this file')" data-button-type="delete"
                                   href="{{ url('backup/delete/'.$backup['file_name']) }}"><i class="fa fa-trash-o"></i>
                                    Delete</a>-->
                            </td>
                              
                             
                          </tr>
                      @endforeach
                      </tbody>
                  </table>
                      @else
                          <div>
                              <h4>No backups</h4>
                          </div>
                      @endif
            </div>
            
          </div>
        </div>
 
  


@endsection