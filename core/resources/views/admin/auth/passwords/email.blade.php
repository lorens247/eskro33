@extends('admin.layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="login-section bg_img" data-background="{{asset('assets/admin/images/1.jpg')}}">
            <div class="left">
                <div class="left-inner">
                    <div class="text-center mb-3">
                        <h2>{{ __($pageTitle) }}</h2>
                        <p>@lang('Just enter your email address so the system can send you a verification code.')</p>
                    </div>
                    <form action="{{ route('admin.password.email') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <div class="custom-field-box">
                                <input type="email" name="email" class="form-control custom-field" id="email" value="{{ old('email') }}" placeholder="@lang('Enter your email')">
                                <i class="las la-envelope input-icon"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn--primary">@lang('Send Code')</button>
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
