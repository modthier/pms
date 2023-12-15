@extends('admin.layouts.sneat')

@section('starter')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add User</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
<section class="col-lg-12">
  
            <div class="card">
               

                
                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf
                        <div class="card-body">
                        <div class="row">
	                        <div class="col-md-6">
	                           <div class="form-group">
	                           	<label for="name">{{ __('Name') }}</label>
	                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

	                            @error('name')
	                                <span class="invalid-feedback" role="alert">
	                                    <strong>{{ $message }}</strong>
	                                </span>
	                            @enderror
	                            </div>
	                        </div>

	                         <div class="col-md-6">
	                         	<div class="form-group">
	                                <label for="email">{{ __('E-Mail Address') }}</label>
	                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

	                                @error('email')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
                                </div>
                            </div>
                        </div>
                        

                        <div class="row">

                        	<div class="col-md-6">
                        		<div class="form-group">
	                        		 <label for="password">{{ __('Password') }}</label>

	                        		  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

	                                @error('password')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
                                </div>
                        	</div>

                        	<div class="col-md-6">
                        		<div class="form-group">
                        			 <label for="password-confirm">{{ __('Confirm Password') }}</label>

                        			 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        		</div>
                        	</div>
                        </div>

                        <div class="row">
                        	<div class="col-md-6">
                        		<div class="form-group">
                        			<label>Role</label>
                        			<select name="role_id" class="form-control">
                        				<option></option>
                        				@foreach ($roles as $role)
                        					<option value="{{$role->id}}">{{$role->name}}</option>
                        				@endforeach
                        			</select>
                        		</div>
                        	</div>
                        </div>

                        
                        </div><!-- end of card-body -->

                        <div class="card-footer">
                            
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            
                        </div>

                     

                    </form>
               
            </div>
      </section> 
@endsection
