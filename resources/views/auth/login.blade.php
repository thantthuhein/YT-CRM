@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{asset('css/auth/login.css')}}">
@endsection

@section('content')

<div class="container login-container">
    <div class="row">
        <div class="col-6">
            <div class="logo-section">
                <div class="logo-image logo-image">
                    <a href="{{ route('admin.home') }}">
                        <img class="w-25" src="https://res.cloudinary.com/dcs3zcs3v/image/upload/v1576135130/logo_mono.png" alt="">
                    </a>
                    <h2 class="banner-font title-text font-weight-bold text-light">
                        YWAR TAW
                    </h2>
                    <p class="text-uppercase text-light">international trading co.,ltd.</p>
                    <p class="copyright-text text-light">Copyright 2019 &copy; Ywar Taw</p>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body login-card-body">
                    <h5 class="text-dark font-weight-bold mb-4">
                        {{ trans('global.account_login') }}
                    </h5>
        
                    @if(session()->has('message'))
                        <p class="alert alert-info">
                            {{ session()->get('message') }}
                        </p>
                    @endif
        
                    <form class="login-section" action="{{ route('login') }}" method="POST">
                        @csrf
        
                        <!-- <div class="form-group">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" name="email" value="{{ old('email', null) }}">
        
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div> -->
                        <div class="form-group">
                            <label class="font-weight-light" for="phone_number">phone number</label>
                            <input id="phone_number" type="phone_number" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }} login-input" required name="phone_number" value='09-'>
        
                            @if($errors->has('phone_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone_number') }}
                                </div>
                            @endif
                        </div>
        
                        <div class="form-group">
                            <label class="font-weight-light" for="password">password</label>

                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} login-input" name="password" required>
        
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
        
        
                        <div class="row">
                            {{-- <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" name="remember" id="remember">
                                    <label for="remember">{{ trans('global.remember_me') }}</label>
                                </div>
                            </div> --}}
                            <!-- /.col -->
                            <div class="col-8">
                                <button type="submit" class="btn btn-primary login-button">
                                    {{ trans('global.login') }}
                                </button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
        
        
                    {{-- @if(Route::has('password.request'))
                        <p class="mb-1">
                            <a href="{{ route('password.request') }}">
                                {{ trans('global.forgot_password') }}
                            </a>
                        </p>
                    @endif
                    <p class="mb-1">
        
                    </p> --}}
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
</div>
@endsection