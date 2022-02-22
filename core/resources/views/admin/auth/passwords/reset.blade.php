@extends('admin.layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="login-section bg_img" data-background="{{asset('assets/admin/images/1.jpg')}}">
            <div class="left">
                <div class="left-inner">

                    <div class="text-center mb-3">
                        <h2>{{ __($pageTitle) }}</h2>
                        <p>@lang('Please enter the new password you want to set. The password is case sensitive.')</p>
                    </div>

                    <form action="{{ route('admin.password.change') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <div class="custom-field-box">
                                <input type="password" name="password" class="form-control custom-field" value="{{ old('password') }}" placeholder="@lang('New Password')">
                                <i class="las la-lock input-icon"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-field-box">
                                <input type="password" name="password_confirmation" class="form-control custom-field" value="{{ old('password_confirmation') }}" placeholder="@lang('Retype New Password')">
                                <i class="las la-lock input-icon"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn--primary">@lang('Reset Password')</button>
                        </div>

                        <div class="form-group text-center">
                            <a href="{{ route('admin.login') }}" class="text-muted"><i class="las la-sign-in-alt me-1"></i>@lang('Back to login')</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
