@extends('admin.app')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Update User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Update User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
<section class="col-lg-12">
      <div class="card">
        <form method="POST" action="{{ route('register.update',$user->id) }}">
            {{ csrf_field() }} 
            {{ method_field('PUT') }}
            <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                 <div class="form-group">
                 	<label for="name">{{ __('Name') }}</label>
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  </div>
              </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Shift</label>
                        <select name="shift_id" class="form-control">
                            <option></option>
                            @foreach ($shifts as $shift)
                                <option value="{{$shift->id}}">{{$shift->shift}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            
            </div><!-- end of card-body -->

            <div class="card-footer">
                
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                
            </div>

         

        </form>
         
      </div>
      </section> 
@endsection
