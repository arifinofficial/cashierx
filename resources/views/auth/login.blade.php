@extends('layouts.app')

@section('content')
<div class="container vh-100">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            required value="{{ old('email') }}" autofocus
                                            placeholder="Enter Email Address...">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password"
                                            class="form-control form-control-user @error('password') is-invalid @enderror"
                                            placeholder="Password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                    <a class="small" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('top')
<style>
    body {
        background-color: #4e73df;
        background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        background-size: cover;
    }

    #wrapper #content-wrapper {
        background: transparent !important;
    }

    .bg-login-image {
        background: url({{ asset('images/cashierx/bg-login.jpg') }} );
        background-position: center;
        background-size: 80%;
    }
</style>
@endpush