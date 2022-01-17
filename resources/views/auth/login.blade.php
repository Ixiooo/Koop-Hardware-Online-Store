@extends('layouts.app')

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>

@endsection

@section('styles')
    <style>

        .form-container{
            margin-top: 35px;
        }

        .forgot-pass{
            color: black;
        }

        .forgot-pass:hover{
            text-decoration: none;
        }
        
        .login-heading{
            font-family: 'Montserrat',  sans-serif ;
            font-size: 32px;
            font-weight: 500;
            color: #4b922d;
        }

        .card-header{
            background-color: #4b922d;
            color: white;
        }

        .icon-bg{
            background-color: #4b922d;
            border: none;
        }

        .input-group span i{
            color: #ffffff;
        }
        
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card w-100">
                <div class="card-header body-text">{{ __('Koop Hardware Login') }}</div>

                <div class="card-body">

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <h3 class="login-heading">
                                Login
                            </h3>
                        </div>
                    </div>
                
                    <div class="form-container">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row justify-content-center">
    
                                <div class="col-md-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text icon-bg"><i class="fas fa-user"> </i> </span>
                                        </div>
                                        <input id="email" type="email" class="form-control body-text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>
    
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group row justify-content-center">
                                
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text icon-bg"><i class="fas fa-key "> </i> </span>
                                        </div>
                                        <input id="password" type="password" class="form-control body-text @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
        
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                            </div>
    
                            <div class="form-group row mb-0">
                                <div class="col-md-10 offset-md-1">
                                    
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link pl-0 forgot-pass" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row mb-0">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn page-btn mr-2 body-text">
                                        {{ __('Login') }}
                                    </button>
                                    <a href="/" class="btn page-btn ml-2 body-text">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                            
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
