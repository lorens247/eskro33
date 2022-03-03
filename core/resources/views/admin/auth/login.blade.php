@extends('admin.layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="login-section bg_img" data-background="{{asset('assets/admin/images/1.jpg')}}">
            <div class="left">
                <div class="left-inner">
                    <div class="text-center mb-3">
                        <h2>{{ __($pageTitle) }}</h2>
                        <p>@lang('Please enter your username-password and login to get access and administrate your system.')</p>
                    </div>
                    <form action="{{ route('admin.login') }}" method="POST" class="verify-gcaptcha">
                        @csrf
                        <div class="form-group">
                            <div class="custom-field-box">
                                <input type="text" name="username" class="form-control custom-field" id="username" value="{{ old('username') }}" placeholder="@lang('Enter username')">
                                <i class="las la-user input-icon"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-field-box">
                                <input type="password" name="password" class="form-control custom-field" id="pass" placeholder="@lang('Enter password')">
                                <i class="las la-lock input-icon"></i>
                            </div>
                        </div>

                        <x-captcha path="admin.partials"></x-captcha>

                        <div class="form-group">
                            <div class="form-check custom-checkbox">
                                <input class="form-check-input" type="checkbox" name="remember" id="remeberMe">
                                <label class="form-check-label text-muted" for="remeberMe">@lang('Remember me')</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block">@lang('Login Now')</button>
                        </div>

                        <div class="form-group text-center">
                            <a href="{{ route('admin.password.reset') }}" class="text-muted"><i class="las la-lock me-1"></i>@lang('Forgot password?')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
