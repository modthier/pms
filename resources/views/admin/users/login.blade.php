@extends('admin.layouts.sneat')

@section('content')

            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body login-card-body">

                    <form method="POST" action="{{ route('user.login') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                  <span class="fas fa-envelope"></span>
                                </div>
                            </div>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Password" autocomplete="current-password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                      <span class="fas fa-lock" onclick="myFunction()"></span>
                                    </div>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                        </div>

                        <div class="input-group mb-3">
                            <select name="shift_id" class="form-control" required>
                                <option value="default">Choose Shift</option>
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->shift }}</option>
                                @endforeach

                                
                            </select>
                             @if(session('shift'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ session('shift') }}</strong>
                                    </span>
                                @endif
                            
                        </div>


                        <div class="row">
                          <div class="col-8">
                            <div class="icheck-primary">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                
                            </div>
                        </div>

                    </form>

                    <p class="mb-1">
                        @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                    </p>
                
            </div>
        </div>
   

@endsection
